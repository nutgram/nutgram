<?php

namespace SergiX44\Nutgram\Telegram\Types\Message;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Properties\MessageType;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Boost\ChatBoostAdded;
use SergiX44\Nutgram\Telegram\Types\Chat\Chat;
use SergiX44\Nutgram\Telegram\Types\Forum\ForumTopicClosed;
use SergiX44\Nutgram\Telegram\Types\Forum\ForumTopicCreated;
use SergiX44\Nutgram\Telegram\Types\Forum\ForumTopicEdited;
use SergiX44\Nutgram\Telegram\Types\Forum\ForumTopicReopened;
use SergiX44\Nutgram\Telegram\Types\Forum\GeneralForumTopicHidden;
use SergiX44\Nutgram\Telegram\Types\Forum\GeneralForumTopicUnhidden;
use SergiX44\Nutgram\Telegram\Types\Forum\WriteAccessAllowed;
use SergiX44\Nutgram\Telegram\Types\Game\Game;
use SergiX44\Nutgram\Telegram\Types\Giveaway\Giveaway;
use SergiX44\Nutgram\Telegram\Types\Giveaway\GiveawayCompleted;
use SergiX44\Nutgram\Telegram\Types\Giveaway\GiveawayCreated;
use SergiX44\Nutgram\Telegram\Types\Giveaway\GiveawayWinners;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ExternalReplyInfo;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ForceReply;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardRemove;
use SergiX44\Nutgram\Telegram\Types\Location\Location;
use SergiX44\Nutgram\Telegram\Types\Location\ProximityAlertTriggered;
use SergiX44\Nutgram\Telegram\Types\Location\Venue;
use SergiX44\Nutgram\Telegram\Types\Media\Animation;
use SergiX44\Nutgram\Telegram\Types\Media\Audio;
use SergiX44\Nutgram\Telegram\Types\Media\Contact;
use SergiX44\Nutgram\Telegram\Types\Media\Dice;
use SergiX44\Nutgram\Telegram\Types\Media\Document;
use SergiX44\Nutgram\Telegram\Types\Media\PhotoSize;
use SergiX44\Nutgram\Telegram\Types\Media\Story;
use SergiX44\Nutgram\Telegram\Types\Media\Video;
use SergiX44\Nutgram\Telegram\Types\Media\VideoNote;
use SergiX44\Nutgram\Telegram\Types\Media\Voice;
use SergiX44\Nutgram\Telegram\Types\Passport\PassportData;
use SergiX44\Nutgram\Telegram\Types\Payment\Invoice;
use SergiX44\Nutgram\Telegram\Types\Payment\PaidMediaInfo;
use SergiX44\Nutgram\Telegram\Types\Payment\RefundedPayment;
use SergiX44\Nutgram\Telegram\Types\Payment\SuccessfulPayment;
use SergiX44\Nutgram\Telegram\Types\Poll\Poll;
use SergiX44\Nutgram\Telegram\Types\Reaction\ReactionType;
use SergiX44\Nutgram\Telegram\Types\Shared\ChatShared;
use SergiX44\Nutgram\Telegram\Types\Shared\UserShared;
use SergiX44\Nutgram\Telegram\Types\Shared\UsersShared;
use SergiX44\Nutgram\Telegram\Types\Sticker\Sticker;
use SergiX44\Nutgram\Telegram\Types\User\User;
use SergiX44\Nutgram\Telegram\Types\VideoChat\VideoChatEnded;
use SergiX44\Nutgram\Telegram\Types\VideoChat\VideoChatParticipantsInvited;
use SergiX44\Nutgram\Telegram\Types\VideoChat\VideoChatScheduled;
use SergiX44\Nutgram\Telegram\Types\VideoChat\VideoChatStarted;
use SergiX44\Nutgram\Telegram\Types\WebApp\WebAppData;

/**
 * This object represents a message.
 * @see https://core.telegram.org/bots/api#message
 */
class Message extends BaseType
{
    /** Unique message identifier inside this chat */
    public int $message_id;

    /**
     * Optional.
     * Unique identifier of a message thread to which the message belongs;
     * for supergroups only
     */
    public ?int $message_thread_id = null;

    /**
     * Optional.
     * Sender of the message;
     * empty for messages sent to channels.
     * For backward compatibility, the field contains a fake sender user in non-channel chats, if the message was sent on behalf of a chat.
     */
    public ?User $from = null;

    /**
     * Optional.
     * Sender of the message, sent on behalf of a chat.
     * For example, the channel itself for channel posts, the supergroup itself for messages from anonymous group administrators, the linked channel for messages automatically forwarded to the discussion group.
     * For backward compatibility, the field from contains a fake sender user in non-channel chats, if the message was sent on behalf of a chat.
     */
    public ?Chat $sender_chat = null;

    /**
     * Optional. If the sender of the message boosted the chat, the number of boosts added by the user
     */
    public ?int $sender_boost_count = null;

    /**
     * Optional. The bot that actually sent the message on behalf of the business account.
     * Available only for outgoing messages sent on behalf of the connected business account.
     */
    public ?User $sender_business_bot = null;

    /** Date the message was sent in Unix time */
    public int $date;

    /**
     * Optional. Unique identifier of the business connection from which the message was received.
     * If non-empty, the message belongs to a chat of the corresponding business account that is independent from any potential bot chat which might share the same identifier.
     */
    public ?string $business_connection_id = null;

    /** Conversation the message belongs to */
    public Chat $chat;

    /**
     * Optional.
     * Information about the original message for forwarded messages
     */
    public ?MessageOrigin $forward_origin = null;

    /**
     * Optional.
     * For forwarded messages, sender of the original message
     * @deprecated Use the $forward_origin field instead
     */
    public ?User $forward_from = null;

    /**
     * Optional.
     * For messages forwarded from channels or from anonymous administrators, information about the original sender chat
     * @deprecated Use the $forward_origin field instead
     */
    public ?Chat $forward_from_chat = null;

    /**
     * Optional.
     * For messages forwarded from channels, identifier of the original message in the channel
     * @deprecated Use the $forward_origin field instead
     */
    public ?int $forward_from_message_id = null;

    /**
     * Optional.
     * For forwarded messages that were originally sent in channels or by an anonymous chat administrator, signature of the message sender if present
     * @deprecated Use the $forward_origin field instead
     */
    public ?string $forward_signature = null;

    /**
     * Optional.
     * Sender's name for messages forwarded from users who disallow adding a link to their account in forwarded messages
     * @deprecated Use the $forward_origin field instead
     */
    public ?string $forward_sender_name = null;

    /**
     * Optional.
     * For forwarded messages, date the original message was sent in Unix time
     * @deprecated Use the $forward_origin field instead
     */
    public ?int $forward_date = null;

    /**
     * Optional.
     * True, if the message is sent to a forum topic
     */
    public ?bool $is_topic_message = null;

    /**
     * Optional.
     * True, if the message is a channel post that was automatically forwarded to the connected discussion group
     */
    public ?bool $is_automatic_forward = null;

    /**
     * Optional.
     * For replies, the original message.
     * Note that the Message object in this field will not contain further reply_to_message fields even if it itself is a reply.
     */
    public ?Message $reply_to_message = null;

    /**
     * Optional.
     * Information about the message that is being replied to, which may come from another chat or forum topic
     */
    public ?ExternalReplyInfo $external_reply = null;

    /**
     * Optional. For replies that quote part of the original message, the quoted part of the message
     */
    public ?TextQuote $quote = null;

    /**
     * Optional. For replies to a story, the original story
     */
    public ?Story $reply_to_story = null;

    /**
     * Optional.
     * Bot through which the message was sent
     */
    public ?User $via_bot = null;

    /**
     * Optional.
     * Date the message was last edited in Unix time
     */
    public ?int $edit_date = null;

    /**
     * Optional.
     * True, if the message can't be forwarded
     */
    public ?bool $has_protected_content = null;

    /**
     * Optional.
     * True, if the message was sent by an implicit action, for example, as an away or a greeting business message, or as a scheduled message
     */
    public ?bool $is_from_offline = null;

    /**
     * Optional.
     * The unique identifier of a media message group this message belongs to
     */
    public ?string $media_group_id = null;

    /**
     * Optional.
     * Signature of the post author for messages in channels, or the custom title of an anonymous group administrator
     */
    public ?string $author_signature = null;

    /**
     * Optional.
     * For text messages, the actual UTF-8 text of the message
     */
    public ?string $text = null;

    /**
     * Optional.
     * For text messages, special entities like usernames, URLs, bot commands, etc.
     * that appear in the text
     * @var MessageEntity[] $entities
     */
    #[ArrayType(MessageEntity::class)]
    public ?array $entities = null;

    /**
     * Optional. Options used for link preview generation for the message,
     * if it is a text message and link preview options were changed
     */
    public ?LinkPreviewOptions $link_preview_options = null;

    /**
     * Optional. Unique identifier of the message effect added to the message
     */
    public ?string $effect_id = null;
    /**
     * Optional.
     * Message is an animation, information about the animation.
     * For backward compatibility, when this field is set, the document field will also be set
     */
    public ?Animation $animation = null;

    /**
     * Optional.
     * Message is an audio file, information about the file
     */
    public ?Audio $audio = null;

    /**
     * Optional.
     * Message is a general file, information about the file
     */
    public ?Document $document = null;

    /**
     * Optional. Message contains paid media; information about the paid media
     */
    public ?PaidMediaInfo $paid_media = null;

    /**
     * Optional.
     * Message is a photo, available sizes of the photo
     * @var PhotoSize[] $photo
     */
    #[ArrayType(PhotoSize::class)]
    public ?array $photo = null;

    /**
     * Optional.
     * Message is a sticker, information about the sticker
     */
    public ?Sticker $sticker = null;

    /**
     * Optional.
     * Message is a forwarded story
     */
    public ?Story $story = null;

    /**
     * Optional.
     * Message is a video, information about the video
     */
    public ?Video $video = null;

    /**
     * Optional.
     * Message is a {@see https://telegram.org/blog/video-messages-and-telescope video note}, information about the video message
     */
    public ?VideoNote $video_note = null;

    /**
     * Optional.
     * Message is a voice message, information about the file
     */
    public ?Voice $voice = null;

    /**
     * Optional.
     * Caption for the animation, audio, document, photo, video or voice
     */
    public ?string $caption = null;

    /**
     * Optional.
     * For messages with a caption, special entities like usernames, URLs, bot commands, etc.
     * that appear in the caption
     * @var MessageEntity[] $caption_entities
     */
    #[ArrayType(MessageEntity::class)]
    public ?array $caption_entities = null;

    /**
     * Optional. True, if the caption must be shown above the message media
     */
    public ?bool $show_caption_above_media = null;

    /**
     * Optional.
     * True, if the message media is covered by a spoiler animation
     */
    public ?bool $has_media_spoiler = null;

    /**
     * Optional.
     * Message is a shared contact, information about the contact
     */
    public ?Contact $contact = null;

    /**
     * Optional.
     * Message is a dice with random value
     */
    public ?Dice $dice = null;

    /**
     * Optional.
     * Message is a game, information about the game.
     * {@see https://core.telegram.org/bots/api#games More about games »}
     */
    public ?Game $game = null;

    /**
     * Optional.
     * Message is a native poll, information about the poll
     */
    public ?Poll $poll = null;

    /**
     * Optional.
     * Message is a venue, information about the venue.
     * For backward compatibility, when this field is set, the location field will also be set
     */
    public ?Venue $venue = null;

    /**
     * Optional.
     * Message is a shared location, information about the location
     */
    public ?Location $location = null;

    /**
     * Optional.
     * New members that were added to the group or supergroup and information about them (the bot itself may be one of these members)
     * @var User[] $new_chat_members
     */
    #[ArrayType(User::class)]
    public ?array $new_chat_members = null;

    /**
     * Optional.
     * A member was removed from the group, information about them (this member may be the bot itself)
     */
    public ?User $left_chat_member = null;

    /**
     * Optional.
     * A chat title was changed to this value
     */
    public ?string $new_chat_title = null;

    /**
     * Optional.
     * A chat photo was change to this value
     * @var PhotoSize[] $new_chat_photo
     */
    #[ArrayType(PhotoSize::class)]
    public ?array $new_chat_photo = null;

    /**
     * Optional.
     * Service message: the chat photo was deleted
     */
    public ?bool $delete_chat_photo = null;

    /**
     * Optional.
     * Service message: the group has been created
     */
    public ?bool $group_chat_created = null;

    /**
     * Optional.
     * Service message: the supergroup has been created.
     * This field can't be received in a message coming through updates, because bot can't be a member of a supergroup when it is created.
     * It can only be found in reply_to_message if someone replies to a very first message in a directly created supergroup.
     */
    public ?bool $supergroup_chat_created = null;

    /**
     * Optional.
     * Service message: the channel has been created.
     * This field can't be received in a message coming through updates, because bot can't be a member of a channel when it is created.
     * It can only be found in reply_to_message if someone replies to a very first message in a channel.
     */
    public ?bool $channel_chat_created = null;

    /**
     * Optional.
     * Service message: auto-delete timer settings changed in the chat
     */
    public ?MessageAutoDeleteTimerChanged $message_auto_delete_timer_changed = null;

    /**
     * Optional.
     * The group has been migrated to a supergroup with the specified identifier.
     * This number may have more than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it.
     * But it has at most 52 significant bits, so a signed 64-bit integer or double-precision float type are safe for storing this identifier.
     */
    public ?int $migrate_to_chat_id = null;

    /**
     * Optional.
     * The supergroup has been migrated from a group with the specified identifier.
     * This number may have more than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it.
     * But it has at most 52 significant bits, so a signed 64-bit integer or double-precision float type are safe for storing this identifier.
     */
    public ?int $migrate_from_chat_id = null;

    /**
     * Optional.
     * Specified message was pinned.
     * Note that the Message object in this field will not contain further reply_to_message fields even if it is itself a reply.
     */
    public ?Message $pinned_message = null;

    /**
     * Optional.
     * Message is an invoice for a {@see https://core.telegram.org/bots/api#payments payment}, information about the invoice.
     * {@see https://core.telegram.org/bots/api#payments More about payments »}
     */
    public ?Invoice $invoice = null;

    /**
     * Optional.
     * Message is a service message about a successful payment, information about the payment.
     * {@see https://core.telegram.org/bots/api#payments More about payments »}
     */
    public ?SuccessfulPayment $successful_payment = null;

    public ?RefundedPayment $refunded_payment = null;

    /**
     * Optional.
     * Service message: a user was shared with the bot
     * @deprecated Use the $users_shared field instead
     */
    public ?UserShared $user_shared = null;

    /**
     * Optional. Service message: users were shared with the bot
     */
    public ?UsersShared $users_shared = null;

    /**
     * Optional.
     * Service message: a chat was shared with the bot
     */
    public ?ChatShared $chat_shared = null;

    /**
     * Optional.
     * The domain name of the website on which the user has logged in.
     * {@see https://core.telegram.org/widgets/login More about Telegram Login »}
     */
    public ?string $connected_website = null;

    /**
     * Optional.
     * Service message: the user allowed the bot added to the attachment menu to write messages
     */
    public ?WriteAccessAllowed $write_access_allowed = null;

    /**
     * Optional.
     * Telegram Passport data
     */
    public ?PassportData $passport_data = null;

    /**
     * Optional.
     * Service message.
     * A user in the chat triggered another user's proximity alert while sharing Live Location.
     */
    public ?ProximityAlertTriggered $proximity_alert_triggered = null;

    /**
     * Optional.
     * Service message: user boosted the chat
     */
    public ?ChatBoostAdded $boost_added = null;

    /**
     * Optional. Service message: chat background set
     */
    public ?ChatBackground $chat_background_set = null;

    /**
     * Optional.
     * Service message: forum topic created
     */
    public ?ForumTopicCreated $forum_topic_created = null;

    /**
     * Optional.
     * Service message: forum topic edited
     */
    public ?ForumTopicEdited $forum_topic_edited = null;

    /**
     * Optional.
     * Service message: forum topic closed
     */
    public ?ForumTopicClosed $forum_topic_closed = null;

    /**
     * Optional.
     * Service message: forum topic reopened
     */
    public ?ForumTopicReopened $forum_topic_reopened = null;

    /**
     * Optional.
     * Service message: the 'General' forum topic hidden
     */
    public ?GeneralForumTopicHidden $general_forum_topic_hidden = null;

    /**
     * Optional.
     * Service message: the 'General' forum topic unhidden
     */
    public ?GeneralForumTopicUnhidden $general_forum_topic_unhidden = null;

    /**
     * Optional. Service message: a scheduled giveaway was created
     */
    public ?GiveawayCreated $giveaway_created = null;

    /**
     * Optional. The message is a scheduled giveaway message
     */
    public ?Giveaway $giveaway = null;

    /**
     * Optional. A giveaway with public winners was completed
     */
    public ?GiveawayWinners $giveaway_winners = null;

    /**
     * Optional. Service message: a giveaway without public winners was completed
     */
    public ?GiveawayCompleted $giveaway_completed = null;

    /**
     * Optional.
     * Service message: video chat scheduled
     */
    public ?VideoChatScheduled $video_chat_scheduled = null;

    /**
     * Optional.
     * Service message: video chat started
     */
    public ?VideoChatStarted $video_chat_started = null;

    /**
     * Optional.
     * Service message: video chat ended
     */
    public ?VideoChatEnded $video_chat_ended = null;

    /**
     * Optional.
     * Service message: new participants invited to a video chat
     */
    public ?VideoChatParticipantsInvited $video_chat_participants_invited = null;

    /**
     * Optional.
     * Service message: data sent by a Web App
     */
    public ?WebAppData $web_app_data = null;

    /**
     * Optional.
     * Inline keyboard attached to the message.
     * login_url buttons are represented as ordinary url buttons.
     */
    public ?InlineKeyboardMarkup $reply_markup = null;

    /**
     * Returns only the command string without [at]BotUsername
     * Example:
     * IN: /hello param1 param2 or /hello[at]MyDearBot param1 param2
     * OUT: /hello param1 param2
     * @param  string|null  $username
     * @return string|null
     */
    public function getParsedCommand(?string $username = null): ?string
    {
        $tag = $username !== null ? "(@$username)?" : '';
        $pattern = sprintf("/^(?<name>\\/[a-z_]+)%s(?<args> .+)?\$/i", $tag);

        if ($this->text !== null && preg_match($pattern, $this->text, $matches)) {
            return $matches['name'].($matches['args'] ?? '');
        }
        return null;
    }

    /**
     * Check if the message is forwarded
     * @return bool
     */
    public function isForwarded(): bool
    {
        return $this->forward_origin !== null;
    }

    /**
     * Return the current message type
     * @return MessageType|null
     */
    public function getType(): ?MessageType
    {
        return match (true) {
            $this->text !== null => MessageType::TEXT,
            $this->audio !== null => MessageType::AUDIO,
            $this->animation !== null => MessageType::ANIMATION,
            $this->game !== null => MessageType::GAME,
            $this->photo !== null => MessageType::PHOTO,
            $this->sticker !== null => MessageType::STICKER,
            $this->video !== null => MessageType::VIDEO,
            $this->voice !== null => MessageType::VOICE,
            $this->video_note !== null => MessageType::VIDEO_NOTE,
            $this->contact !== null => MessageType::CONTACT,
            $this->venue !== null => MessageType::VENUE,
            $this->location !== null => MessageType::LOCATION,
            $this->story !== null => MessageType::STORY,
            $this->poll !== null => MessageType::POLL,
            $this->dice !== null => MessageType::DICE,
            $this->new_chat_members !== null => MessageType::NEW_CHAT_MEMBERS,
            $this->left_chat_member !== null => MessageType::LEFT_CHAT_MEMBER,
            $this->new_chat_title !== null => MessageType::NEW_CHAT_TITLE,
            $this->new_chat_photo !== null => MessageType::NEW_CHAT_PHOTO,
            $this->delete_chat_photo !== null => MessageType::DELETE_CHAT_PHOTO,
            $this->group_chat_created !== null => MessageType::GROUP_CHAT_CREATED,
            $this->supergroup_chat_created !== null => MessageType::SUPERGROUP_CHAT_CREATED,
            $this->channel_chat_created !== null => MessageType::CHANNEL_CHAT_CREATED,
            $this->migrate_to_chat_id !== null => MessageType::MIGRATE_TO_CHAT_ID,
            $this->migrate_from_chat_id !== null => MessageType::MIGRATE_FROM_CHAT_ID,
            $this->pinned_message !== null => MessageType::PINNED_MESSAGE,
            $this->invoice !== null => MessageType::INVOICE,
            $this->successful_payment !== null => MessageType::SUCCESSFUL_PAYMENT,
            $this->refunded_payment !== null => MessageType::REFUNDED_PAYMENT,
            $this->users_shared !== null => MessageType::USERS_SHARED,
            $this->chat_shared !== null => MessageType::CHAT_SHARED,
            $this->message_auto_delete_timer_changed !== null => MessageType::MESSAGE_AUTO_DELETE_TIMER_CHANGED,
            $this->connected_website !== null => MessageType::CONNECTED_WEBSITE,
            $this->passport_data !== null => MessageType::PASSPORT_DATA,
            $this->proximity_alert_triggered !== null => MessageType::PROXIMITY_ALERT_TRIGGERED,
            $this->boost_added !== null => MessageType::BOOST_ADDED,
            $this->forum_topic_created !== null => MessageType::FORUM_TOPIC_CREATED,
            $this->forum_topic_edited !== null => MessageType::FORUM_TOPIC_EDITED,
            $this->forum_topic_closed !== null => MessageType::FORUM_TOPIC_CLOSED,
            $this->forum_topic_reopened !== null => MessageType::FORUM_TOPIC_REOPENED,
            $this->giveaway_created !== null => MessageType::GIVEAWAY_CREATED,
            $this->giveaway !== null => MessageType::GIVEAWAY,
            $this->giveaway_winners !== null => MessageType::GIVEAWAY_WINNERS,
            $this->giveaway_completed !== null => MessageType::GIVEAWAY_COMPLETED,
            $this->video_chat_scheduled !== null => MessageType::VIDEO_CHAT_SCHEDULED,
            $this->video_chat_started !== null => MessageType::VIDEO_CHAT_STARTED,
            $this->video_chat_ended !== null => MessageType::VIDEO_CHAT_ENDED,
            $this->video_chat_participants_invited !== null => MessageType::VIDEO_CHAT_PARTICIPANTS_INVITED,
            $this->web_app_data !== null => MessageType::WEB_APP_DATA,
            $this->document !== null => MessageType::DOCUMENT,
            default => null
        };
    }

    /**
     * Returns the message text or caption
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text ?? $this->caption;
    }

    /**
     * Return the message entities
     * @return MessageEntity[]|null
     */
    public function getEntities(): ?array
    {
        return $this->entities ?? $this->caption_entities;
    }

    /**
     * Delete the current message
     * @return bool|null
     */
    public function delete(): ?bool
    {
        return $this->getBot()->deleteMessage(
            chat_id: $this->chat->id,
            message_id: $this->message_id
        );
    }

    /**
     * Edit the current message text
     * On success, if the edited message is not an inline message, the edited {@see https://core.telegram.org/bots/api#message Message} is returned, otherwise True is returned.
     * @see https://core.telegram.org/bots/api#editmessagetext
     * @param string $text New text of the message, 1-4096 characters after entities parsing
     * @param int|string|null $chat_id Required if inline_message_id is not specified. Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int|null $message_id Required if inline_message_id is not specified. Identifier of the message to edit
     * @param string|null $inline_message_id Required if chat_id and message_id are not specified. Identifier of the inline message
     * @param ParseMode|string|null $parse_mode Mode for parsing entities in the message text. See {@see https://core.telegram.org/bots/api#formatting-options formatting options} for more details.
     * @param MessageEntity[]|null $entities A JSON-serialized list of special entities that appear in message text, which can be specified instead of parse_mode
     * @param bool|null $disable_web_page_preview Disables link previews for links in this message
     * @param InlineKeyboardMarkup|null $reply_markup A JSON-serialized object for an {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}.
     * @return Message|bool|null
     * @see Nutgram::editMessageText
     */
    public function editText(
        string $text,
        int|string|null $chat_id = null,
        ?int $message_id = null,
        ?string $inline_message_id = null,
        ParseMode|string|null $parse_mode = null,
        ?array $entities = null,
        ?bool $disable_web_page_preview = null,
        ?InlineKeyboardMarkup $reply_markup = null,
    ): Message|bool|null {
        $chat_id ??= $this->chat->id;
        $message_id ??= $this->message_id;

        return $this->getBot()->editMessageText(
            text: $text,
            chat_id: $chat_id,
            message_id: $message_id,
            inline_message_id: $inline_message_id,
            parse_mode: $parse_mode,
            entities: $entities,
            disable_web_page_preview: $disable_web_page_preview,
            reply_markup: $reply_markup,
        );
    }

    /**
     * Copy the current message
     * Service messages and invoice messages can't be copied.
     * A quiz {@see https://core.telegram.org/bots/api#poll poll} can be copied only if the value of the field correct_option_id is known to the bot.
     * The method is analogous to the method {@see https://core.telegram.org/bots/api#forwardmessage forwardMessage}, but the copied message doesn't have a link to the original message.
     * Returns the {@see https://core.telegram.org/bots/api#messageid MessageId} of the sent message on success.
     * @see https://core.telegram.org/bots/api#copymessage
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int|string|null $from_chat_id Unique identifier for the chat where the original message was sent (or channel username in the format &#64;channelusername)
     * @param int|null $message_id Message identifier in the chat specified in from_chat_id
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param string|null $caption New caption for media, 0-1024 characters after entities parsing. If not specified, the original caption is kept
     * @param ParseMode|string|null $parse_mode Mode for parsing entities in the new caption. See {@see https://core.telegram.org/bots/api#formatting-options formatting options} for more details.
     * @param MessageEntity[]|null $caption_entities A JSON-serialized list of special entities that appear in the new caption, which can be specified instead of parse_mode
     * @param bool|null $disable_notification Sends the message {@see https://telegram.org/blog/channels-2-0#silent-messages silently}. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param int|null $reply_to_message_id If the message is a reply, ID of the original message
     * @param bool|null $allow_sending_without_reply Pass True if the message should be sent even if the specified replied-to message is not found
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}, {@see https://core.telegram.org/bots/features#keyboards custom reply keyboard}, instructions to remove reply keyboard or to force a reply from the user.
     * @return MessageId|null
     * @see Nutgram::copyMessage
     */
    public function copy(
        int|string $chat_id,
        int|string|null $from_chat_id = null,
        ?int $message_id = null,
        ?int $message_thread_id = null,
        ?string $caption = null,
        ParseMode|string|null $parse_mode = null,
        ?array $caption_entities = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
        ?int $reply_to_message_id = null,
        ?bool $allow_sending_without_reply = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
    ): ?MessageId {
        $from_chat_id ??= $this->chat->id;
        $message_id ??= $this->message_id;

        return $this->getBot()->copyMessage(
            chat_id: $chat_id,
            from_chat_id: $from_chat_id,
            message_id: $message_id,
            message_thread_id: $message_thread_id,
            caption: $caption,
            parse_mode: $parse_mode,
            caption_entities: $caption_entities,
            disable_notification: $disable_notification,
            protect_content: $protect_content,
            reply_to_message_id: $reply_to_message_id,
            allow_sending_without_reply: $allow_sending_without_reply,
            reply_markup: $reply_markup,
        );
    }

    /**
     * Forward the current message
     * Service messages can't be forwarded.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * @see https://core.telegram.org/bots/api#forwardmessage
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int|string|null $from_chat_id Unique identifier for the chat where the original message was sent (or channel username in the format &#64;channelusername)
     * @param int|null $message_id Message identifier in the chat specified in from_chat_id
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param bool|null $disable_notification Sends the message {@see https://telegram.org/blog/channels-2-0#silent-messages silently}. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the forwarded message from forwarding and saving
     * @return Message|null
     * @see Nutgram::forwardMessage
     */
    public function forward(
        int|string $chat_id,
        int|string|null $from_chat_id = null,
        ?int $message_id = null,
        ?int $message_thread_id = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
    ): ?Message {
        $from_chat_id ??= $this->chat->id;
        $message_id ??= $this->message_id;

        return $this->getBot()->forwardMessage(
            chat_id: $chat_id,
            from_chat_id: $from_chat_id,
            message_id: $message_id,
            message_thread_id: $message_thread_id,
            disable_notification: $disable_notification,
            protect_content: $protect_content,
        );
    }

    /**
     * Check if this message is deleted or is inaccessible to the bot.
     * @return bool
     */
    public function isInaccessible(): bool
    {
        return $this->date === 0;
    }

    /**
     * Use this method to change the chosen reactions on a message.
     * Service messages can't be reacted to.
     * Automatically forwarded messages from a channel to its discussion group have the same available reactions as messages in the channel.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#setmessagereaction
     * @param ReactionType|ReactionType[]|null $reaction Optional. New list of reaction types to set on the message. Currently, as non-premium users, bots can set up to one reaction per message. A custom emoji reaction can be used if it is either already present on the message or explicitly allowed by chat administrators.
     * @param bool $is_big Optional. Pass True to set the reaction with a big animation
     * @return bool|null
     */
    public function react(ReactionType|array|null $reaction = null, bool $is_big = false): ?bool
    {
        if ($reaction instanceof ReactionType) {
            $reaction = [$reaction];
        }

        return $this->getBot()->setMessageReaction(
            reaction: $reaction,
            is_big: $is_big,
            chat_id: $this->chat->id,
            message_id: $this->message_id
        );
    }
}
