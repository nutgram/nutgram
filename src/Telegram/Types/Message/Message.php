<?php

namespace SergiX44\Nutgram\Telegram\Types\Message;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Attributes\MessageTypes;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Chat\Chat;
use SergiX44\Nutgram\Telegram\Types\Forum\ForumTopicClosed;
use SergiX44\Nutgram\Telegram\Types\Forum\ForumTopicCreated;
use SergiX44\Nutgram\Telegram\Types\Forum\ForumTopicEdited;
use SergiX44\Nutgram\Telegram\Types\Forum\ForumTopicReopened;
use SergiX44\Nutgram\Telegram\Types\Forum\GeneralForumTopicHidden;
use SergiX44\Nutgram\Telegram\Types\Forum\GeneralForumTopicUnhidden;
use SergiX44\Nutgram\Telegram\Types\Forum\WriteAccessAllowed;
use SergiX44\Nutgram\Telegram\Types\Game\Game;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Location\Location;
use SergiX44\Nutgram\Telegram\Types\Location\ProximityAlertTriggered;
use SergiX44\Nutgram\Telegram\Types\Location\Venue;
use SergiX44\Nutgram\Telegram\Types\Media\Animation;
use SergiX44\Nutgram\Telegram\Types\Media\Audio;
use SergiX44\Nutgram\Telegram\Types\Media\Contact;
use SergiX44\Nutgram\Telegram\Types\Media\Dice;
use SergiX44\Nutgram\Telegram\Types\Media\Document;
use SergiX44\Nutgram\Telegram\Types\Media\PhotoSize;
use SergiX44\Nutgram\Telegram\Types\Media\Video;
use SergiX44\Nutgram\Telegram\Types\Media\VideoNote;
use SergiX44\Nutgram\Telegram\Types\Media\Voice;
use SergiX44\Nutgram\Telegram\Types\Passport\PassportData;
use SergiX44\Nutgram\Telegram\Types\Payment\Invoice;
use SergiX44\Nutgram\Telegram\Types\Payment\SuccessfulPayment;
use SergiX44\Nutgram\Telegram\Types\Poll\Poll;
use SergiX44\Nutgram\Telegram\Types\Shared\ChatShared;
use SergiX44\Nutgram\Telegram\Types\Shared\UserShared;
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
    /**
     * Unique message identifier inside this chat
     */
    public int $message_id;

    /**
     * Optional. Unique identifier of a message thread to which the message belongs; for supergroups only
     */
    public ?int $message_thread_id = null;

    /**
     * Optional. Sender, can be empty for messages sent to channels
     */
    public ?User $from = null;

    /**
     * Optional. Sender of the message, sent on behalf of a chat. The channel itself for channel messages.
     * The supergroup itself for messages from anonymous group administrators.
     * The linked channel for messages automatically forwarded to the discussion group
     */
    public ?Chat $sender_chat = null;

    /**
     * Date the message was sent in Unix time
     */
    public int $date;

    /**
     * Conversation the message belongs to
     */
    public Chat $chat;

    /**
     * Optional. For forwarded messages, sender of the original message
     */
    public ?User $forward_from = null;

    /**
     * Optional. For messages forwarded from a channel, information about the original channel
     */
    public ?Chat $forward_from_chat = null;

    /**
     * Optional. For forwarded channel posts, identifier of the original message in the channel
     */
    public ?int $forward_from_message_id = null;

    /**
     * Optional. Signature of the post author for messages forwarded from channels
     */
    public ?string $forward_signature = null;

    /**
     * Optional. Sender's name for messages forwarded from users who
     * disallow adding a link to their account in forwarded messages
     */
    public ?string $forward_sender_name = null;

    /**
     * Optional. Sender's name for messages forwarded from users who disallow
     * adding a link to their account in forwarded messages
     */
    public ?int $forward_date = null;

    /**
     * Optional. True, if the message is sent to a forum topic
     */
    public ?bool $is_topic_message = null;

    /**
     * Optional. True, if the message is a channel post that was automatically forwarded
     * to the connected discussion group
     * @var int|null
     */
    public ?int $is_automatic_forward = null;

    /**
     * Optional. For replies, the original message.
     * Note that the Message object in this field will not contain further
     * reply_to_message fields even if it itself is a reply.
     */
    public ?Message $reply_to_message = null;

    /**
     * Optional. Bot through which the message was sent
     */
    public ?User $via_bot = null;

    /**
     * Optional. Date the message was last edited in Unix time
     */
    public ?int $edit_date = null;

    /**
     * Optional. True, if the message can't be forwarded
     * @var bool|null
     */
    public ?bool $has_protected_content = null;

    /**
     * Optional. The unique identifier of a media message group this message belongs to
     */
    public ?string $media_group_id = null;

    /**
     * Optional. Signature of the post author for messages in channels,
     * or the custom title of an anonymous group administrator
     */
    public ?string $author_signature = null;

    /**
     * Optional. For text messages, the actual UTF-8 text of the message, 0-4096 characters
     */
    public ?string $text = null;

    /**
     * Optional. For text messages, special entities like usernames, URLs, bot commands, etc. that appear in the text
     * @var \SergiX44\Nutgram\Telegram\Types\Message\MessageEntity[] $entities
     */
    #[ArrayType(MessageEntity::class)]
    public ?array $entities = null;

    /**
     * Optional. Message is an animation, information about the animation.
     * For backward compatibility, when this field is set, the document field will also be set
     */
    public ?Animation $animation = null;

    /**
     * Optional. Message is an audio file, information about the file
     */
    public ?Audio $audio = null;

    /**
     * Optional. Message is a general file, information about the file
     */
    public ?Document $document = null;

    /**
     * Optional. Message is a game, information about the game.
     * @see https://core.telegram.org/bots/api#games More about games »
     */
    public ?Game $game = null;

    /**
     * Optional. Message is a photo, available sizes of the photo
     * @var \SergiX44\Nutgram\Telegram\Types\Media\PhotoSize[] $photo
     */
    #[ArrayType(PhotoSize::class)]
    public ?array $photo = null;

    /**
     * Optional. Message is a sticker, information about the sticker
     */
    public ?Sticker $sticker = null;

    /**
     * Optional. Message is a video, information about the video
     */
    public ?Video $video = null;

    /**
     * Optional. Message is a voice message, information about the file
     */
    public ?Voice $voice = null;

    /**
     * Optional. Message is a video note, information about the video message
     * @see https://telegram.org/blog/video-messages-and-telescope video note
     */
    public ?VideoNote $video_note = null;

    /**
     * Optional. Caption for the document, photo or video, 0-1024 characters
     */
    public ?string $caption = null;

    /**
     * Optional. List of special entities that appear in the caption, which can be specified instead of parse_mode
     * @var \SergiX44\Nutgram\Telegram\Types\Message\MessageEntity[] $caption_entities
     */
    #[ArrayType(MessageEntity::class)]
    public ?array $caption_entities = null;

    /**
     * Optional. True, if the message media is covered by a spoiler animation
     */
    public ?bool $has_media_spoiler = null;

    /**
     * Optional. Message is a shared contact, information about the contact
     */
    public ?Contact $contact = null;

    /**
     * Optional. Message is a shared location, information about the location
     */
    public ?Location $location = null;

    /**
     * Optional. Message is a venue, information about the venue
     */
    public ?Venue $venue = null;

    /**
     * Optional. Message is a native poll, information about the poll
     */
    public ?Poll $poll = null;

    /**
     * Optional. Message is a dice with random value from 1 to 6
     */
    public ?Dice $dice = null;

    /**
     * Optional. New members that were added to the group or supergroup
     * and information about them (the bot itself may be one of these members)
     * @var \SergiX44\Nutgram\Telegram\Types\User\User[] $new_chat_members
     */
    #[ArrayType(User::class)]
    public ?array $new_chat_members = null;

    /**
     * Optional. A member was removed from the group, information about them (this member may be the bot itself)
     */
    public ?User $left_chat_member = null;

    /**
     * Optional. A chat title was changed to this value
     */
    public ?string $new_chat_title = null;

    /**
     * Optional. A chat photo was change to this value
     * @var \SergiX44\Nutgram\Telegram\Types\Media\PhotoSize[] $new_chat_photo
     */
    #[ArrayType(PhotoSize::class)]
    public ?array $new_chat_photo = null;

    /**
     * Optional. Service message: the chat photo was deleted
     */
    public ?bool $delete_chat_photo = null;

    /**
     * Optional. Service message: the group has been created
     */
    public ?bool $group_chat_created = null;

    /**
     * Optional. Service message: the supergroup has been created.
     * This field can‘t be received in a message coming through updates,
     * because bot can’t be a member of a supergroup when it is created.
     * It can only be found in reply_to_message if someone replies to a
     * very first message in a directly created supergroup.
     */
    public ?bool $supergroup_chat_created = null;

    /**
     * Optional. Service message: the channel has been created.
     * This field can‘t be received in a message coming through updates,
     * because bot can’t be a member of a channel when it is created.
     * It can only be found in reply_to_message if someone replies to a very first message in a channel.
     */
    public ?bool $channel_chat_created = null;

    /**
     * Optional. Service message: auto-delete timer settings changed in the chat
     */
    public ?MessageAutoDeleteTimerChanged $message_auto_delete_timer_changed = null;

    /**
     * Optional. The group has been migrated to a supergroup with the specified identifier.
     * This number may be greater than 32 bits and some programming languages
     * may have difficulty/silent defects in interpreting it.
     * But it smaller than 52 bits, so a signed 64 bit integer or
     * double-precision float type are safe for storing this identifier.
     */
    public ?int $migrate_to_chat_id = null;

    /**
     * Optional. The supergroup has been migrated from a group with the specified identifier.
     * This number may be greater than 32 bits and some programming languages
     * may have difficulty/silent defects in interpreting it.
     * But it smaller than 52 bits, so a signed 64 bit integer or
     * double-precision float type are safe for storing this identifier.
     */
    public ?int $migrate_from_chat_id = null;

    /**
     * Optional. Specified message was pinned.
     * Note that the Message object in this field will not contain
     * further reply_to_message fields even if it is itself a reply.
     */
    public ?Message $pinned_message = null;

    /**
     * Optional. Message is an invoice for a payment, information about the invoice.
     * @see https://core.telegram.org/bots/api#payments invoice
     * @see https://core.telegram.org/bots/api#payments More about payments
     */
    public ?Invoice $invoice = null;

    /**
     * Optional. Message is a service message about a successful payment, information about the payment.
     * @see https://core.telegram.org/bots/api#payments More about payments
     */
    public ?SuccessfulPayment $successful_payment = null;

    /**
     * Optional. Service message: a user was shared with the bot
     */
    public ?UserShared $user_shared = null;

    /**
     * Optional. Service message: a chat was shared with the bot
     */
    public ?ChatShared $chat_shared = null;

    /**
     * Optional. The domain name of the website on which the user has logged in.
     * @see https://core.telegram.org/widgets/login More about Telegram Login
     */
    public ?string $connected_website = null;

    /**
     * Optional. Service message: the user allowed the bot added to the attachment menu to write messages
     */
    public ?WriteAccessAllowed $write_access_allowed = null;

    /**
     * Optional. Telegram Passport data
     */
    public ?PassportData $passport_data = null;

    /**
     * Optional. Service message.
     * A user in the chat triggered another user's proximity alert while sharing Live Location.
     */
    public ?ProximityAlertTriggered $proximity_alert_triggered = null;

    /**
     * Optional. Service message: forum topic created
     */
    public ?ForumTopicCreated $forum_topic_created = null;

    /**
     * Optional. Service message: forum topic edited
     */
    public ?ForumTopicEdited $forum_topic_edited = null;

    /**
     * Optional. Service message: forum topic closed
     */
    public ?ForumTopicClosed $forum_topic_closed = null;

    /**
     * Optional. Service message: forum topic reopened
     */
    public ?ForumTopicReopened $forum_topic_reopened = null;

    /**
     * Optional. Service message: the 'General' forum topic hidden
     */
    public ?GeneralForumTopicHidden $general_forum_topic_hidden = null;

    /**
     * Optional. Service message: the 'General' forum topic unhidden
     */
    public ?GeneralForumTopicUnhidden $general_forum_topic_unhidden = null;

    /**
     * Optional. Service message: voice chat scheduled
     */
    public ?VideoChatScheduled $video_chat_scheduled = null;

    /**
     * Optional. Service message: voice chat started
     */
    public ?VideoChatStarted $video_chat_started = null;

    /**
     * Optional. Service message: voice chat ended
     */
    public ?VideoChatEnded $video_chat_ended = null;

    /**
     * Optional. Service message: new participants invited to a voice chat
     */
    public ?VideoChatParticipantsInvited $video_chat_participants_invited = null;

    /**
     * Optional. Service message: data sent by a Web App
     */
    public ?WebAppData $web_app_data = null;

    /**
     * Optional. Optional. Inline keyboard attached to the message.
     * "login_url" buttons are represented as ordinary "url" buttons.
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
        $pattern = sprintf("/^(?<name>\\/[a-z]+)%s(?<args> .+)?\$/i", $tag);

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
        return $this->forward_from !== null || $this->forward_from_chat !== null;
    }

    /**
     * Return the current message type
     * @return string|null
     */
    public function getType(): ?string
    {
        return match (true) {
            $this->text !== null => MessageTypes::TEXT,
            $this->audio !== null => MessageTypes::AUDIO,
            $this->animation !== null => MessageTypes::ANIMATION,
            $this->document !== null => MessageTypes::DOCUMENT,
            $this->game !== null => MessageTypes::GAME,
            $this->photo !== null => MessageTypes::PHOTO,
            $this->sticker !== null => MessageTypes::STICKER,
            $this->video !== null => MessageTypes::VIDEO,
            $this->voice !== null => MessageTypes::VOICE,
            $this->video_note !== null => MessageTypes::VIDEO_NOTE,
            $this->contact !== null => MessageTypes::CONTACT,
            $this->venue !== null => MessageTypes::VENUE,
            $this->location !== null => MessageTypes::LOCATION,
            $this->poll !== null => MessageTypes::POLL,
            $this->dice !== null => MessageTypes::DICE,
            $this->new_chat_members !== null => MessageTypes::NEW_CHAT_MEMBERS,
            $this->left_chat_member !== null => MessageTypes::LEFT_CHAT_MEMBER,
            $this->new_chat_title !== null => MessageTypes::NEW_CHAT_TITLE,
            $this->new_chat_photo !== null => MessageTypes::NEW_CHAT_PHOTO,
            $this->delete_chat_photo !== null => MessageTypes::DELETE_CHAT_PHOTO,
            $this->group_chat_created !== null => MessageTypes::GROUP_CHAT_CREATED,
            $this->supergroup_chat_created !== null => MessageTypes::SUPERGROUP_CHAT_CREATED,
            $this->channel_chat_created !== null => MessageTypes::CHANNEL_CHAT_CREATED,
            $this->migrate_to_chat_id !== null => MessageTypes::MIGRATE_TO_CHAT_ID,
            $this->migrate_from_chat_id !== null => MessageTypes::MIGRATE_FROM_CHAT_ID,
            $this->pinned_message !== null => MessageTypes::PINNED_MESSAGE,
            $this->invoice !== null => MessageTypes::INVOICE,
            $this->successful_payment !== null => MessageTypes::SUCCESSFUL_PAYMENT,
            $this->message_auto_delete_timer_changed !== null => MessageTypes::MESSAGE_AUTO_DELETE_TIMER_CHANGED,
            $this->connected_website !== null => MessageTypes::CONNECTED_WEBSITE,
            $this->passport_data !== null => MessageTypes::PASSPORT_DATA,
            $this->proximity_alert_triggered !== null => MessageTypes::PROXIMITY_ALERT_TRIGGERED,
            $this->forum_topic_created !== null => MessageTypes::FORUM_TOPIC_CREATED,
            $this->forum_topic_edited !== null => MessageTypes::FORUM_TOPIC_EDITED,
            $this->forum_topic_closed !== null => MessageTypes::FORUM_TOPIC_CLOSED,
            $this->forum_topic_reopened !== null => MessageTypes::FORUM_TOPIC_REOPENED,
            $this->video_chat_scheduled !== null => MessageTypes::VIDEO_CHAT_SCHEDULED,
            $this->video_chat_started !== null => MessageTypes::VIDEO_CHAT_STARTED,
            $this->video_chat_ended !== null => MessageTypes::VIDEO_CHAT_ENDED,
            $this->video_chat_participants_invited !== null => MessageTypes::VIDEO_CHAT_PARTICIPANTS_INVITED,
            $this->web_app_data !== null => MessageTypes::WEB_APP_DATA,
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
        return $this->bot->deleteMessage($this->chat->id, $this->message_id);
    }

    /**
     * Edit the current message text
     * @param  string  $text
     * @param  array  $opt
     * @return Message|bool|null
     * @see Nutgram::editMessageText
     */
    public function editText(string $text, array $opt = []): Message|bool|null
    {
        return $this->bot->editMessageText($text, array_merge([
            'chat_id' => $this->chat->id,
            'message_id' => $this->message_id,
        ], $opt));
    }

    /**
     * Copy the current message
     * @param  string|int  $chatId
     * @param  array  $opt
     * @return MessageId|null
     * @see Nutgram::copyMessage
     */
    public function copy(string|int $chatId, array $opt = []): ?MessageId
    {
        return $this->bot->copyMessage($chatId, $this->chat->id, $this->message_id, $opt);
    }

    /**
     * Forward the current message
     * @param  string|int  $chatId
     * @param  array  $opt
     * @return Message|null
     * @see Nutgram::forwardMessage
     */
    public function forward(string|int $chatId, array $opt = []): ?Message
    {
        return $this->bot->forwardMessage($chatId, $this->chat->id, $this->message_id, $opt);
    }
}
