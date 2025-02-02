<?php

namespace SergiX44\Nutgram\Telegram\Endpoints;

use SergiX44\Nutgram\Telegram\Client;
use SergiX44\Nutgram\Telegram\Properties\ChatAction;
use SergiX44\Nutgram\Telegram\Properties\DiceEmoji;
use SergiX44\Nutgram\Telegram\Properties\ForumIconColor;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Properties\PollType;
use SergiX44\Nutgram\Telegram\Types\Boost\UserChatBoosts;
use SergiX44\Nutgram\Telegram\Types\Business\BusinessConnection;
use SergiX44\Nutgram\Telegram\Types\Chat\Chat;
use SergiX44\Nutgram\Telegram\Types\Chat\ChatAdministratorRights;
use SergiX44\Nutgram\Telegram\Types\Chat\ChatInviteLink;
use SergiX44\Nutgram\Telegram\Types\Chat\ChatMember;
use SergiX44\Nutgram\Telegram\Types\Chat\ChatPermissions;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommand;
use SergiX44\Nutgram\Telegram\Types\Command\BotCommandScope;
use SergiX44\Nutgram\Telegram\Types\Command\MenuButton;
use SergiX44\Nutgram\Telegram\Types\Description\BotDescription;
use SergiX44\Nutgram\Telegram\Types\Description\BotName;
use SergiX44\Nutgram\Telegram\Types\Description\BotShortDescription;
use SergiX44\Nutgram\Telegram\Types\Forum\ForumTopic;
use SergiX44\Nutgram\Telegram\Types\Input\InputMediaAudio;
use SergiX44\Nutgram\Telegram\Types\Input\InputMediaDocument;
use SergiX44\Nutgram\Telegram\Types\Input\InputMediaPhoto;
use SergiX44\Nutgram\Telegram\Types\Input\InputMediaVideo;
use SergiX44\Nutgram\Telegram\Types\Input\InputPaidMedia;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;
use SergiX44\Nutgram\Telegram\Types\Internal\UploadableArray;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ForceReply;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardRemove;
use SergiX44\Nutgram\Telegram\Types\Media\File;
use SergiX44\Nutgram\Telegram\Types\Message\LinkPreviewOptions;
use SergiX44\Nutgram\Telegram\Types\Message\Message;
use SergiX44\Nutgram\Telegram\Types\Message\MessageEntity;
use SergiX44\Nutgram\Telegram\Types\Message\MessageId;
use SergiX44\Nutgram\Telegram\Types\Message\ReplyParameters;
use SergiX44\Nutgram\Telegram\Types\Poll\InputPollOption;
use SergiX44\Nutgram\Telegram\Types\Reaction\ReactionType;
use SergiX44\Nutgram\Telegram\Types\Sticker\Sticker;
use SergiX44\Nutgram\Telegram\Types\User\User;
use SergiX44\Nutgram\Telegram\Types\User\UserProfilePhotos;

/**
 * Trait AvailableMethods
 * @package SergiX44\Nutgram\Telegram\Endpoints
 * @mixin Client
 */
trait AvailableMethods
{
    /**
     * A simple method for testing your bot's authentication token.
     * Requires no parameters.
     * Returns basic information about the bot in form of a {@see https://core.telegram.org/bots/api#user User} object.
     * @see https://core.telegram.org/bots/api#getme
     * @return User|null
     */
    public function getMe(): ?User
    {
        return $this->requestJson(__FUNCTION__, mapTo: User::class);
    }

    /**
     * Use this method to log out from the cloud Bot API server before launching the bot locally.
     * You must log out the bot before running it locally, otherwise there is no guarantee that the bot will receive updates.
     * After a successful call, you can immediately log in on a local server, but will not be able to log in back to the cloud Bot API server for 10 minutes.
     * Returns True on success.
     * Requires no parameters.
     * @see https://core.telegram.org/bots/api#logout
     * @return bool|null
     */
    public function logOut(): ?bool
    {
        return $this->requestJson(__FUNCTION__);
    }

    /**
     * Use this method to close the bot instance before moving it from one local server to another.
     * You need to delete the webhook before calling this method to ensure that the bot isn't launched again after server restart.
     * The method will return error 429 in the first 10 minutes after the bot is launched.
     * Returns True on success.
     * Requires no parameters.
     * @see https://core.telegram.org/bots/api#close
     * @return bool|null
     */
    public function close(): ?bool
    {
        return $this->requestJson(__FUNCTION__);
    }

    /**
     * Use this method to send text messages.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * @see https://core.telegram.org/bots/api#sendmessage
     * @param string $text Text of the message to be sent, 1-4096 characters after entities parsing
     * @param int|string|null $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param ParseMode|string|null $parse_mode Mode for parsing entities in the message text. See {@see https://core.telegram.org/bots/api#formatting-options formatting options} for more details.
     * @param MessageEntity[]|null $entities A JSON-serialized list of special entities that appear in message text, which can be specified instead of parse_mode
     * @param bool|null $disable_web_page_preview Disables link previews for links in this message
     * @param LinkPreviewOptions|null $link_preview_options Link preview generation options for the message
     * @param bool|null $disable_notification Sends the message {@see https://telegram.org/blog/channels-2-0#silent-messages silently}. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param int|null $reply_to_message_id If the message is a reply, ID of the original message
     * @param bool|null $allow_sending_without_reply Pass True if the message should be sent even if the specified replied-to message is not found
     * @param ReplyParameters|null $reply_parameters Description of the message to reply to
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}, {@see https://core.telegram.org/bots/features#keyboards custom reply keyboard}, instructions to remove reply keyboard or to force a reply from the user.
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param bool|null $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring {@see https://core.telegram.org/bots/faq#how-can-i-message-all-of-my-bot-39s-subscribers-at-once broadcasting limits} for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @return Message|null
     */
    public function sendMessage(
        string $text,
        int|string|null $chat_id = null,
        ?int $message_thread_id = null,
        ParseMode|string|null $parse_mode = null,
        ?array $entities = null,
        ?bool $disable_web_page_preview = null,
        ?LinkPreviewOptions $link_preview_options = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
        ?int $reply_to_message_id = null,
        ?bool $allow_sending_without_reply = null,
        ?ReplyParameters $reply_parameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
        ?string $business_connection_id = null,
        ?string $message_effect_id = null,
        ?bool $allow_paid_broadcast = null,
    ): ?Message {
        $chat_id ??= $this->chatId();
        $message_thread_id ??= $this->messageThreadId();
        $business_connection_id ??= $this->businessConnectionId();
        $parameters = compact(
            'chat_id',
            'message_thread_id',
            'text',
            'parse_mode',
            'entities',
            'disable_web_page_preview',
            'link_preview_options',
            'disable_notification',
            'protect_content',
            'reply_to_message_id',
            'allow_sending_without_reply',
            'reply_parameters',
            'reply_markup',
            'business_connection_id',
            'message_effect_id',
            'allow_paid_broadcast',
        );

        return $this->requestJson(__FUNCTION__, $parameters, Message::class);
    }

    /**
     * Use this method to forward messages of any kind.
     * Service messages can't be forwarded.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * @see https://core.telegram.org/bots/api#forwardmessage
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int|string $from_chat_id Unique identifier for the chat where the original message was sent (or channel username in the format &#64;channelusername)
     * @param int $message_id Message identifier in the chat specified in from_chat_id
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param bool|null $disable_notification Sends the message {@see https://telegram.org/blog/channels-2-0#silent-messages silently}. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the forwarded message from forwarding and saving
     * @return Message|null
     */
    public function forwardMessage(
        int|string $chat_id,
        int|string $from_chat_id,
        int $message_id,
        ?int $message_thread_id = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
    ): ?Message {
        return $this->requestJson(__FUNCTION__, compact(
            'chat_id',
            'message_thread_id',
            'from_chat_id',
            'disable_notification',
            'protect_content',
            'message_id'
        ), Message::class);
    }

    /**
     * Use this method to forward multiple messages of any kind.
     * If some of the specified messages can't be found or forwarded, they are skipped.
     * Service messages and messages with protected content can't be forwarded.
     * Album grouping is kept for forwarded messages.
     * On success, an array of {@see https://core.telegram.org/bots/api#messageid MessageId} of the sent messages is returned.
     * @see https://core.telegram.org/bots/api#forwardmessages
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int|string $from_chat_id Unique identifier for the chat where the original messages were sent (or channel username in the format &#64;channelusername)
     * @param array $message_ids Identifiers of 1-100 messages in the chat from_chat_id to forward. The identifiers must be specified in a strictly increasing order.
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param bool|null $disable_notification Sends the messages {@see https://telegram.org/blog/channels-2-0#silent-messages silently}. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the forwarded messages from forwarding and saving
     * @return MessageId[]|null
     */
    public function forwardMessages(
        int|string $chat_id,
        int|string $from_chat_id,
        array $message_ids,
        ?int $message_thread_id = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
    ): ?array {
        return $this->requestJson(__FUNCTION__, compact(
            'chat_id',
            'from_chat_id',
            'message_ids',
            'message_thread_id',
            'disable_notification',
            'protect_content'
        ), MessageId::class);
    }

    /**
     * Use this method to copy messages of any kind.
     * Service messages, paid media messages, giveaway messages, giveaway winners messages, and invoice messages can't be copied.
     * A quiz {@see https://core.telegram.org/bots/api#poll poll} can be copied only if the value of the field correct_option_id is known to the bot.
     * The method is analogous to the method {@see https://core.telegram.org/bots/api#forwardmessage forwardMessage}, but the copied message doesn't have a link to the original message.
     * Returns the {@see https://core.telegram.org/bots/api#messageid MessageId} of the sent message on success.
     * @see https://core.telegram.org/bots/api#copymessage
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int|string $from_chat_id Unique identifier for the chat where the original message was sent (or channel username in the format &#64;channelusername)
     * @param int $message_id Message identifier in the chat specified in from_chat_id
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param string|null $caption New caption for media, 0-1024 characters after entities parsing. If not specified, the original caption is kept
     * @param ParseMode|string|null $parse_mode Mode for parsing entities in the new caption. See {@see https://core.telegram.org/bots/api#formatting-options formatting options} for more details.
     * @param MessageEntity[]|null $caption_entities A JSON-serialized list of special entities that appear in the new caption, which can be specified instead of parse_mode
     * @param bool|null $disable_notification Sends the message {@see https://telegram.org/blog/channels-2-0#silent-messages silently}. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param int|null $reply_to_message_id If the message is a reply, ID of the original message
     * @param bool|null $allow_sending_without_reply Pass True if the message should be sent even if the specified replied-to message is not found
     * @param ReplyParameters|null $reply_parameters Description of the message to reply to
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}, {@see https://core.telegram.org/bots/features#keyboards custom reply keyboard}, instructions to remove reply keyboard or to force a reply from the user.
     * @param bool|null $show_caption_above_media Pass True, if the caption must be shown above the message media
     * @param bool|null $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring {@see https://core.telegram.org/bots/faq#how-can-i-message-all-of-my-bot-39s-subscribers-at-once broadcasting limits} for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @return MessageId|null
     */
    public function copyMessage(
        int|string $chat_id,
        int|string $from_chat_id,
        int $message_id,
        ?int $message_thread_id = null,
        ?string $caption = null,
        ParseMode|string|null $parse_mode = null,
        ?array $caption_entities = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
        ?int $reply_to_message_id = null,
        ?bool $allow_sending_without_reply = null,
        ?ReplyParameters $reply_parameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
        ?bool $show_caption_above_media = null,
        ?bool $allow_paid_broadcast = null,
    ): ?MessageId {
        return $this->requestJson(__FUNCTION__, compact(
            'chat_id',
            'message_thread_id',
            'from_chat_id',
            'message_id',
            'caption',
            'parse_mode',
            'caption_entities',
            'disable_notification',
            'protect_content',
            'reply_to_message_id',
            'allow_sending_without_reply',
            'reply_parameters',
            'reply_markup',
            'show_caption_above_media',
            'allow_paid_broadcast',
        ), MessageId::class);
    }

    /**
     * Use this method to copy messages of any kind.
     * If some of the specified messages can't be found or copied, they are skipped.
     * Service messages, paid media messages, giveaway messages, giveaway winners messages, and invoice messages can't be copied.
     * A quiz {@see https://core.telegram.org/bots/api#poll poll} can be copied only if the value of the field correct_option_id is known to the bot.
     * The method is analogous to the method {@see https://core.telegram.org/bots/api#forwardmessages forwardMessages}, but the copied messages don't have a link to the original message.
     * Album grouping is kept for copied messages.
     * On success, an array of {@see https://core.telegram.org/bots/api#messageid MessageId} of the sent messages is returned.
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int|string $from_chat_id Unique identifier for the chat where the original messages were sent (or channel username in the format &#64;channelusername)
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param array|null $message_ids Identifiers of 1-100 messages in the chat from_chat_id to copy. The identifiers must be specified in a strictly increasing order.
     * @param bool|null $disable_notification Sends the messages silently. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent messages from forwarding and saving
     * @param bool|null $remove_caption Pass True to copy the messages without their captions
     * @return MessageId[]|null
     */
    public function copyMessages(
        int|string $chat_id,
        int|string $from_chat_id,
        ?int $message_thread_id = null,
        ?array $message_ids = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
        ?bool $remove_caption = null,
    ): ?array {
        return $this->requestJson(__FUNCTION__, compact(
            'chat_id',
            'from_chat_id',
            'message_thread_id',
            'message_ids',
            'disable_notification',
            'protect_content',
            'remove_caption'
        ), MessageId::class);
    }

    /**
     * Use this method to send photos.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * @see https://core.telegram.org/bots/api#sendphoto
     * @param InputFile|string $photo Photo to send. Pass a file_id as String to send a photo that exists on the Telegram servers (recommended), pass an HTTP URL as a String for Telegram to get a photo from the Internet, or upload a new photo using multipart/form-data. The photo must be at most 10 MB in size. The photo's width and height must not exceed 10000 in total. Width and height ratio must be at most 20. {@see https://core.telegram.org/bots/api#sending-files More information on Sending Files »}
     * @param int|string|null $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param string|null $caption Photo caption (may also be used when resending photos by file_id), 0-1024 characters after entities parsing
     * @param ParseMode|string|null $parse_mode Mode for parsing entities in the photo caption. See {@see https://core.telegram.org/bots/api#formatting-options formatting options} for more details.
     * @param MessageEntity[]|null $caption_entities A JSON-serialized list of special entities that appear in the caption, which can be specified instead of parse_mode
     * @param bool|null $has_spoiler Pass True if the photo needs to be covered with a spoiler animation
     * @param bool|null $disable_notification Sends the message {@see https://telegram.org/blog/channels-2-0#silent-messages silently}. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param int|null $reply_to_message_id If the message is a reply, ID of the original message
     * @param bool|null $allow_sending_without_reply Pass True if the message should be sent even if the specified replied-to message is not found
     * @param ReplyParameters|null $reply_parameters Description of the message to reply to
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}, {@see https://core.telegram.org/bots/features#keyboards custom reply keyboard}, instructions to remove reply keyboard or to force a reply from the user.
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param bool|null $show_caption_above_media Pass True, if the caption must be shown above the message media
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param bool|null $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring {@see https://core.telegram.org/bots/faq#how-can-i-message-all-of-my-bot-39s-subscribers-at-once broadcasting limits} for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @param array $clientOpt Client options
     * @return Message|null
     */
    public function sendPhoto(
        InputFile|string $photo,
        int|string|null $chat_id = null,
        ?int $message_thread_id = null,
        ?string $caption = null,
        ParseMode|string|null $parse_mode = null,
        ?array $caption_entities = null,
        ?bool $has_spoiler = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
        ?int $reply_to_message_id = null,
        ?bool $allow_sending_without_reply = null,
        ?ReplyParameters $reply_parameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
        ?string $business_connection_id = null,
        ?bool $show_caption_above_media = null,
        ?string $message_effect_id = null,
        ?bool $allow_paid_broadcast = null,
        array $clientOpt = [],
    ): ?Message {
        $chat_id ??= $this->chatId();
        $message_thread_id ??= $this->messageThreadId();
        $business_connection_id ??= $this->businessConnectionId();
        $opt = compact(
            'chat_id',
            'message_thread_id',
            'caption',
            'parse_mode',
            'caption_entities',
            'has_spoiler',
            'disable_notification',
            'protect_content',
            'reply_to_message_id',
            'allow_sending_without_reply',
            'reply_parameters',
            'reply_markup',
            'business_connection_id',
            'show_caption_above_media',
            'message_effect_id',
            'allow_paid_broadcast',
        );

        return $this->sendAttachment(__FUNCTION__, 'photo', $photo, $opt, $clientOpt);
    }

    /**
     * Use this method to send audio files, if you want Telegram clients to display them in the music player.
     * Your audio must be in the .MP3 or .M4A format.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * Bots can currently send audio files of up to 50 MB in size, this limit may be changed in the future.
     * @see https://core.telegram.org/bots/api#sendaudio
     * @param InputFile|string $audio Audio file to send. Pass a file_id as String to send an audio file that exists on the Telegram servers (recommended), pass an HTTP URL as a String for Telegram to get an audio file from the Internet, or upload a new one using multipart/form-data. {@see https://core.telegram.org/bots/api#sending-files More information on Sending Files »}
     * @param int|string|null $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param string|null $caption Audio caption, 0-1024 characters after entities parsing
     * @param ParseMode|string|null $parse_mode Mode for parsing entities in the audio caption. See {@see https://core.telegram.org/bots/api#formatting-options formatting options} for more details.
     * @param MessageEntity[]|null $caption_entities A JSON-serialized list of special entities that appear in the caption, which can be specified instead of parse_mode
     * @param int|null $duration Duration of the audio in seconds
     * @param string|null $performer Performer
     * @param string|null $title Track name
     * @param InputFile|string|null $thumbnail Thumbnail of the file sent; can be ignored if thumbnail generation for the file is supported server-side. The thumbnail should be in JPEG format and less than 200 kB in size. A thumbnail's width and height should not exceed 320. Ignored if the file is not uploaded using multipart/form-data. Thumbnails can't be reused and can be only uploaded as a new file, so you can pass “attach://<file_attach_name>” if the thumbnail was uploaded using multipart/form-data under <file_attach_name>. {@see https://core.telegram.org/bots/api#sending-files More information on Sending Files »}
     * @param bool|null $disable_notification Sends the message {@see https://telegram.org/blog/channels-2-0#silent-messages silently}. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param int|null $reply_to_message_id If the message is a reply, ID of the original message
     * @param bool|null $allow_sending_without_reply Pass True if the message should be sent even if the specified replied-to message is not found
     * @param ReplyParameters|null $reply_parameters Description of the message to reply to
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}, {@see https://core.telegram.org/bots/features#keyboards custom reply keyboard}, instructions to remove reply keyboard or to force a reply from the user.
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param bool|null $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring {@see https://core.telegram.org/bots/faq#how-can-i-message-all-of-my-bot-39s-subscribers-at-once broadcasting limits} for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @param array $clientOpt Client options
     * @return Message|null
     */
    public function sendAudio(
        InputFile|string $audio,
        int|string|null $chat_id = null,
        ?int $message_thread_id = null,
        ?string $caption = null,
        ParseMode|string|null $parse_mode = null,
        ?array $caption_entities = null,
        ?int $duration = null,
        ?string $performer = null,
        ?string $title = null,
        InputFile|string|null $thumbnail = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
        ?int $reply_to_message_id = null,
        ?bool $allow_sending_without_reply = null,
        ?ReplyParameters $reply_parameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
        ?string $business_connection_id = null,
        ?string $message_effect_id = null,
        ?bool $allow_paid_broadcast = null,
        array $clientOpt = [],
    ): ?Message {
        $chat_id ??= $this->chatId();
        $message_thread_id ??= $this->messageThreadId();
        $business_connection_id ??= $this->businessConnectionId();
        $opt = compact(
            'chat_id',
            'message_thread_id',
            'caption',
            'parse_mode',
            'caption_entities',
            'duration',
            'performer',
            'title',
            'thumbnail',
            'disable_notification',
            'protect_content',
            'reply_to_message_id',
            'allow_sending_without_reply',
            'reply_parameters',
            'reply_markup',
            'business_connection_id',
            'message_effect_id',
            'allow_paid_broadcast',
        );

        return $this->sendAttachment(__FUNCTION__, 'audio', $audio, $opt, $clientOpt);
    }

    /**
     * Use this method to send general files.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * Bots can currently send files of any type of up to 50 MB in size, this limit may be changed in the future.
     * @see https://core.telegram.org/bots/api#senddocument
     * @param InputFile|string $document File to send. Pass a file_id as String to send a file that exists on the Telegram servers (recommended), pass an HTTP URL as a String for Telegram to get a file from the Internet, or upload a new one using multipart/form-data. {@see https://core.telegram.org/bots/api#sending-files More information on Sending Files »}
     * @param int|string|null $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param InputFile|string|null $thumbnail Thumbnail of the file sent; can be ignored if thumbnail generation for the file is supported server-side. The thumbnail should be in JPEG format and less than 200 kB in size. A thumbnail's width and height should not exceed 320. Ignored if the file is not uploaded using multipart/form-data. Thumbnails can't be reused and can be only uploaded as a new file, so you can pass “attach://<file_attach_name>” if the thumbnail was uploaded using multipart/form-data under <file_attach_name>. {@see https://core.telegram.org/bots/api#sending-files More information on Sending Files »}
     * @param string|null $caption Document caption (may also be used when resending documents by file_id), 0-1024 characters after entities parsing
     * @param ParseMode|string|null $parse_mode Mode for parsing entities in the document caption. See {@see https://core.telegram.org/bots/api#formatting-options formatting options} for more details.
     * @param MessageEntity[]|null $caption_entities A JSON-serialized list of special entities that appear in the caption, which can be specified instead of parse_mode
     * @param bool|null $disable_content_type_detection Disables automatic server-side content type detection for files uploaded using multipart/form-data
     * @param bool|null $disable_notification Sends the message {@see https://telegram.org/blog/channels-2-0#silent-messages silently}. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param int|null $reply_to_message_id If the message is a reply, ID of the original message
     * @param bool|null $allow_sending_without_reply Pass True if the message should be sent even if the specified replied-to message is not found
     * @param ReplyParameters|null $reply_parameters Description of the message to reply to
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}, {@see https://core.telegram.org/bots/features#keyboards custom reply keyboard}, instructions to remove reply keyboard or to force a reply from the user.
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param bool|null $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring {@see https://core.telegram.org/bots/faq#how-can-i-message-all-of-my-bot-39s-subscribers-at-once broadcasting limits} for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @param array $clientOpt Client options
     * @return Message|null
     */
    public function sendDocument(
        InputFile|string $document,
        int|string|null $chat_id = null,
        ?int $message_thread_id = null,
        InputFile|string|null $thumbnail = null,
        ?string $caption = null,
        ParseMode|string|null $parse_mode = null,
        ?array $caption_entities = null,
        ?bool $disable_content_type_detection = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
        ?int $reply_to_message_id = null,
        ?bool $allow_sending_without_reply = null,
        ?ReplyParameters $reply_parameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
        ?string $business_connection_id = null,
        ?string $message_effect_id = null,
        ?bool $allow_paid_broadcast = null,
        array $clientOpt = [],
    ): ?Message {
        $chat_id ??= $this->chatId();
        $message_thread_id ??= $this->messageThreadId();
        $business_connection_id ??= $this->businessConnectionId();
        $opt = compact(
            'chat_id',
            'message_thread_id',
            'thumbnail',
            'caption',
            'parse_mode',
            'caption_entities',
            'disable_content_type_detection',
            'disable_notification',
            'protect_content',
            'reply_to_message_id',
            'allow_sending_without_reply',
            'reply_parameters',
            'reply_markup',
            'business_connection_id',
            'message_effect_id',
            'allow_paid_broadcast',
        );

        return $this->sendAttachment(__FUNCTION__, 'document', $document, $opt, $clientOpt);
    }

    /**
     * Use this method to send video files, Telegram clients support MPEG4 videos (other formats may be sent as {@see https://core.telegram.org/bots/api#document Document}).
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * Bots can currently send video files of up to 50 MB in size, this limit may be changed in the future.
     * @see https://core.telegram.org/bots/api#sendvideo
     * @param InputFile|string $video Video to send. Pass a file_id as String to send a video that exists on the Telegram servers (recommended), pass an HTTP URL as a String for Telegram to get a video from the Internet, or upload a new video using multipart/form-data. {@see https://core.telegram.org/bots/api#sending-files More information on Sending Files »}
     * @param int|string|null $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param int|null $duration Duration of sent video in seconds
     * @param int|null $width Video width
     * @param int|null $height Video height
     * @param InputFile|string|null $thumbnail Thumbnail of the file sent; can be ignored if thumbnail generation for the file is supported server-side. The thumbnail should be in JPEG format and less than 200 kB in size. A thumbnail's width and height should not exceed 320. Ignored if the file is not uploaded using multipart/form-data. Thumbnails can't be reused and can be only uploaded as a new file, so you can pass “attach://<file_attach_name>” if the thumbnail was uploaded using multipart/form-data under <file_attach_name>. {@see https://core.telegram.org/bots/api#sending-files More information on Sending Files »}
     * @param string|null $caption Video caption (may also be used when resending videos by file_id), 0-1024 characters after entities parsing
     * @param ParseMode|string|null $parse_mode Mode for parsing entities in the video caption. See {@see https://core.telegram.org/bots/api#formatting-options formatting options} for more details.
     * @param MessageEntity[]|null $caption_entities A JSON-serialized list of special entities that appear in the caption, which can be specified instead of parse_mode
     * @param bool|null $has_spoiler Pass True if the video needs to be covered with a spoiler animation
     * @param bool|null $supports_streaming Pass True if the uploaded video is suitable for streaming
     * @param bool|null $disable_notification Sends the message {@see https://telegram.org/blog/channels-2-0#silent-messages silently}. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param int|null $reply_to_message_id If the message is a reply, ID of the original message
     * @param bool|null $allow_sending_without_reply Pass True if the message should be sent even if the specified replied-to message is not found
     * @param ReplyParameters|null $reply_parameters Description of the message to reply to
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}, {@see https://core.telegram.org/bots/features#keyboards custom reply keyboard}, instructions to remove reply keyboard or to force a reply from the user.
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param bool|null $show_caption_above_media Pass True, if the caption must be shown above the message media
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param bool|null $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring {@see https://core.telegram.org/bots/faq#how-can-i-message-all-of-my-bot-39s-subscribers-at-once broadcasting limits} for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @param array $clientOpt Client options
     * @return Message|null
     */
    public function sendVideo(
        InputFile|string $video,
        int|string|null $chat_id = null,
        ?int $message_thread_id = null,
        ?int $duration = null,
        ?int $width = null,
        ?int $height = null,
        InputFile|string|null $thumbnail = null,
        ?string $caption = null,
        ParseMode|string|null $parse_mode = null,
        ?array $caption_entities = null,
        ?bool $has_spoiler = null,
        ?bool $supports_streaming = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
        ?int $reply_to_message_id = null,
        ?bool $allow_sending_without_reply = null,
        ?ReplyParameters $reply_parameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
        ?string $business_connection_id = null,
        ?bool $show_caption_above_media = null,
        ?string $message_effect_id = null,
        ?bool $allow_paid_broadcast = null,
        array $clientOpt = [],
    ): ?Message {
        $chat_id ??= $this->chatId();
        $message_thread_id ??= $this->messageThreadId();
        $business_connection_id ??= $this->businessConnectionId();
        $opt = compact(
            'chat_id',
            'message_thread_id',
            'duration',
            'width',
            'height',
            'thumbnail',
            'caption',
            'parse_mode',
            'caption_entities',
            'has_spoiler',
            'supports_streaming',
            'disable_notification',
            'protect_content',
            'reply_to_message_id',
            'allow_sending_without_reply',
            'reply_parameters',
            'reply_markup',
            'business_connection_id',
            'show_caption_above_media',
            'message_effect_id',
            'allow_paid_broadcast',
        );

        return $this->sendAttachment(__FUNCTION__, 'video', $video, $opt, $clientOpt);
    }

    /**
     * Use this method to send animation files (GIF or H.264/MPEG-4 AVC video without sound).
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * Bots can currently send animation files of up to 50 MB in size, this limit may be changed in the future.
     * @see https://core.telegram.org/bots/api#sendanimation
     * @param InputFile|string $animation Animation to send. Pass a file_id as String to send an animation that exists on the Telegram servers (recommended), pass an HTTP URL as a String for Telegram to get an animation from the Internet, or upload a new animation using multipart/form-data. {@see https://core.telegram.org/bots/api#sending-files More information on Sending Files »}
     * @param int|string|null $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param int|null $duration Duration of sent animation in seconds
     * @param int|null $width Animation width
     * @param int|null $height Animation height
     * @param InputFile|string|null $thumbnail Thumbnail of the file sent; can be ignored if thumbnail generation for the file is supported server-side. The thumbnail should be in JPEG format and less than 200 kB in size. A thumbnail's width and height should not exceed 320. Ignored if the file is not uploaded using multipart/form-data. Thumbnails can't be reused and can be only uploaded as a new file, so you can pass “attach://<file_attach_name>” if the thumbnail was uploaded using multipart/form-data under <file_attach_name>. {@see https://core.telegram.org/bots/api#sending-files More information on Sending Files »}
     * @param string|null $caption Animation caption (may also be used when resending animation by file_id), 0-1024 characters after entities parsing
     * @param ParseMode|string|null $parse_mode Mode for parsing entities in the animation caption. See {@see https://core.telegram.org/bots/api#formatting-options formatting options} for more details.
     * @param MessageEntity[]|null $caption_entities A JSON-serialized list of special entities that appear in the caption, which can be specified instead of parse_mode
     * @param bool|null $has_spoiler Pass True if the animation needs to be covered with a spoiler animation
     * @param bool|null $disable_notification Sends the message {@see https://telegram.org/blog/channels-2-0#silent-messages silently}. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param int|null $reply_to_message_id If the message is a reply, ID of the original message
     * @param bool|null $allow_sending_without_reply Pass True if the message should be sent even if the specified replied-to message is not found
     * @param ReplyParameters|null $reply_parameters Description of the message to reply to
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}, {@see https://core.telegram.org/bots/features#keyboards custom reply keyboard}, instructions to remove reply keyboard or to force a reply from the user.
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param bool|null $show_caption_above_media Pass True, if the caption must be shown above the message media
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param bool|null $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring {@see https://core.telegram.org/bots/faq#how-can-i-message-all-of-my-bot-39s-subscribers-at-once broadcasting limits} for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @param array $clientOpt Client options
     * @return Message|null
     */
    public function sendAnimation(
        InputFile|string $animation,
        int|string|null $chat_id = null,
        ?int $message_thread_id = null,
        ?int $duration = null,
        ?int $width = null,
        ?int $height = null,
        InputFile|string|null $thumbnail = null,
        ?string $caption = null,
        ParseMode|string|null $parse_mode = null,
        ?array $caption_entities = null,
        ?bool $has_spoiler = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
        ?int $reply_to_message_id = null,
        ?bool $allow_sending_without_reply = null,
        ?ReplyParameters $reply_parameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
        ?string $business_connection_id = null,
        ?bool $show_caption_above_media = null,
        ?string $message_effect_id = null,
        ?bool $allow_paid_broadcast = null,
        array $clientOpt = [],
    ): ?Message {
        $chat_id ??= $this->chatId();
        $message_thread_id ??= $this->messageThreadId();
        $business_connection_id ??= $this->businessConnectionId();
        $opt = compact(
            'chat_id',
            'message_thread_id',
            'duration',
            'width',
            'height',
            'thumbnail',
            'caption',
            'parse_mode',
            'caption_entities',
            'has_spoiler',
            'disable_notification',
            'protect_content',
            'reply_to_message_id',
            'allow_sending_without_reply',
            'reply_parameters',
            'reply_markup',
            'business_connection_id',
            'show_caption_above_media',
            'message_effect_id',
            'allow_paid_broadcast',
        );

        return $this->sendAttachment(__FUNCTION__, 'animation', $animation, $opt, $clientOpt);
    }

    /**
     * Use this method to send audio files, if you want Telegram clients to display the file as a playable voice message.
     * For this to work, your audio must be in an .OGG file encoded with OPUS, or in .MP3 format, or in .M4A format (other formats may be sent as {@see https://core.telegram.org/bots/api#audio Audio} or {@see https://core.telegram.org/bots/api#document Document}).
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * Bots can currently send voice messages of up to 50 MB in size, this limit may be changed in the future.
     * @see https://core.telegram.org/bots/api#sendvoice
     * @param InputFile|string $voice Audio file to send. Pass a file_id as String to send a file that exists on the Telegram servers (recommended), pass an HTTP URL as a String for Telegram to get a file from the Internet, or upload a new one using multipart/form-data. {@see https://core.telegram.org/bots/api#sending-files More information on Sending Files »}
     * @param int|string|null $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param string|null $caption Voice message caption, 0-1024 characters after entities parsing
     * @param ParseMode|string|null $parse_mode Mode for parsing entities in the voice message caption. See {@see https://core.telegram.org/bots/api#formatting-options formatting options} for more details.
     * @param MessageEntity[]|null $caption_entities A JSON-serialized list of special entities that appear in the caption, which can be specified instead of parse_mode
     * @param int|null $duration Duration of the voice message in seconds
     * @param bool|null $disable_notification Sends the message {@see https://telegram.org/blog/channels-2-0#silent-messages silently}. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param int|null $reply_to_message_id If the message is a reply, ID of the original message
     * @param bool|null $allow_sending_without_reply Pass True if the message should be sent even if the specified replied-to message is not found
     * @param ReplyParameters|null $reply_parameters Description of the message to reply to
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}, {@see https://core.telegram.org/bots/features#keyboards custom reply keyboard}, instructions to remove reply keyboard or to force a reply from the user.
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param bool|null $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring {@see https://core.telegram.org/bots/faq#how-can-i-message-all-of-my-bot-39s-subscribers-at-once broadcasting limits} for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @param array $clientOpt Client options
     * @return Message|null
     */
    public function sendVoice(
        InputFile|string $voice,
        int|string|null $chat_id = null,
        ?int $message_thread_id = null,
        ?string $caption = null,
        ParseMode|string|null $parse_mode = null,
        ?array $caption_entities = null,
        ?int $duration = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
        ?int $reply_to_message_id = null,
        ?bool $allow_sending_without_reply = null,
        ?ReplyParameters $reply_parameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
        ?string $business_connection_id = null,
        ?string $message_effect_id = null,
        ?bool $allow_paid_broadcast = null,
        array $clientOpt = [],
    ): ?Message {
        $chat_id ??= $this->chatId();
        $message_thread_id ??= $this->messageThreadId();
        $business_connection_id ??= $this->businessConnectionId();
        $opt = compact(
            'chat_id',
            'message_thread_id',
            'caption',
            'parse_mode',
            'caption_entities',
            'duration',
            'disable_notification',
            'protect_content',
            'reply_to_message_id',
            'allow_sending_without_reply',
            'reply_parameters',
            'reply_markup',
            'business_connection_id',
            'message_effect_id',
            'allow_paid_broadcast',
        );

        return $this->sendAttachment(__FUNCTION__, 'voice', $voice, $opt, $clientOpt);
    }

    /**
     * As of {@see https://telegram.org/blog/video-messages-and-telescope v.4.0}, Telegram clients support rounded square MPEG4 videos of up to 1 minute long.
     * Use this method to send video messages.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * @see https://core.telegram.org/bots/api#sendvideonote
     * @param InputFile|string $video_note Video note to send. Pass a file_id as String to send a video note that exists on the Telegram servers (recommended) or upload a new video using multipart/form-data. {@see https://core.telegram.org/bots/api#sending-files More information on Sending Files »}. Sending video notes by a URL is currently unsupported
     * @param int|string|null $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param int|null $duration Duration of sent video in seconds
     * @param int|null $length Video width and height, i.e. diameter of the video message
     * @param InputFile|string|null $thumbnail Thumbnail of the file sent; can be ignored if thumbnail generation for the file is supported server-side. The thumbnail should be in JPEG format and less than 200 kB in size. A thumbnail's width and height should not exceed 320. Ignored if the file is not uploaded using multipart/form-data. Thumbnails can't be reused and can be only uploaded as a new file, so you can pass “attach://<file_attach_name>” if the thumbnail was uploaded using multipart/form-data under <file_attach_name>. {@see https://core.telegram.org/bots/api#sending-files More information on Sending Files »}
     * @param bool|null $disable_notification Sends the message {@see https://telegram.org/blog/channels-2-0#silent-messages silently}. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param int|null $reply_to_message_id If the message is a reply, ID of the original message
     * @param bool|null $allow_sending_without_reply Pass True if the message should be sent even if the specified replied-to message is not found
     * @param ReplyParameters|null $reply_parameters Description of the message to reply to
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}, {@see https://core.telegram.org/bots/features#keyboards custom reply keyboard}, instructions to remove reply keyboard or to force a reply from the user.
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param bool|null $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring {@see https://core.telegram.org/bots/faq#how-can-i-message-all-of-my-bot-39s-subscribers-at-once broadcasting limits} for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @param array $clientOpt Client options
     * @return Message|null
     */
    public function sendVideoNote(
        InputFile|string $video_note,
        int|string|null $chat_id = null,
        ?int $message_thread_id = null,
        ?int $duration = null,
        ?int $length = null,
        InputFile|string|null $thumbnail = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
        ?int $reply_to_message_id = null,
        ?bool $allow_sending_without_reply = null,
        ?ReplyParameters $reply_parameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
        ?string $business_connection_id = null,
        ?string $message_effect_id = null,
        ?bool $allow_paid_broadcast = null,
        array $clientOpt = [],
    ): ?Message {
        $chat_id ??= $this->chatId();
        $message_thread_id ??= $this->messageThreadId();
        $business_connection_id ??= $this->businessConnectionId();
        $opt = compact(
            'chat_id',
            'message_thread_id',
            'duration',
            'length',
            'thumbnail',
            'disable_notification',
            'protect_content',
            'reply_to_message_id',
            'allow_sending_without_reply',
            'reply_parameters',
            'reply_markup',
            'business_connection_id',
            'message_effect_id',
            'allow_paid_broadcast',
        );

        return $this->sendAttachment(__FUNCTION__, 'video_note', $video_note, $opt, $clientOpt);
    }

    /**
     * Use this method to send paid media to channel chats.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * @see https://core.telegram.org/bots/api#sendpaidmedia
     * @param int $star_count The number of Telegram Stars that must be paid to buy access to the media
     * @param InputPaidMedia[] $media A JSON-serialized array describing the media to be sent; up to 10 items
     * @param int|string|null $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param string|null $caption Media caption, 0-1024 characters after entities parsing
     * @param ParseMode|string|null $parse_mode Mode for parsing entities in the voice message caption. See {@see https://core.telegram.org/bots/api#formatting-options formatting options} for more details.
     * @param array|null $caption_entities A JSON-serialized list of special entities that appear in the caption, which can be specified instead of parse_mode
     * @param bool|null $show_caption_above_media Pass True, if the caption must be shown above the message media
     * @param bool|null $disable_notification Sends the message {@see https://telegram.org/blog/channels-2-0#silent-messages silently}. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param ReplyParameters|null $reply_parameters Description of the message to reply to
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}, {@see https://core.telegram.org/bots/features#keyboards custom reply keyboard}, instructions to remove reply keyboard or to force a reply from the user.
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param string|null $payload Bot-defined paid media payload, 0-128 bytes. This will not be displayed to the user, use it for your internal processes.
     * @param bool|null $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring {@see https://core.telegram.org/bots/faq#how-can-i-message-all-of-my-bot-39s-subscribers-at-once broadcasting limits} for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @param array $clientOpt Client options
     * @return Message|null
     */
    public function sendPaidMedia(
        int $star_count,
        array $media,
        int|string|null $chat_id = null,
        ?string $caption = null,
        ParseMode|string|null $parse_mode = null,
        ?array $caption_entities = null,
        ?bool $show_caption_above_media = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
        ?ReplyParameters $reply_parameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
        ?string $business_connection_id = null,
        ?string $payload = null,
        ?bool $allow_paid_broadcast = null,
        array $clientOpt = [],
    ): ?Message {
        $chat_id ??= $this->chatId();
        $business_connection_id ??= $this->businessConnectionId();
        $params = compact(
            'star_count',
            'chat_id',
            'caption',
            'parse_mode',
            'caption_entities',
            'show_caption_above_media',
            'disable_notification',
            'protect_content',
            'reply_parameters',
            'reply_markup',
            'business_connection_id',
            'payload',
            'allow_paid_broadcast',
        );

        return $this->requestMultipart(__FUNCTION__, [
            'media' => new UploadableArray($media),
            ...$params,
        ], Message::class, $clientOpt);
    }

    /**
     * Use this method to send a group of photos, videos, documents or audios as an album.
     * Documents and audio files can be only grouped in an album with messages of the same type.
     * On success, an array of {@see https://core.telegram.org/bots/api#message Messages} that were sent is returned.
     * @see https://core.telegram.org/bots/api#sendmediagroup
     * @param InputMediaAudio[]|InputMediaDocument[]|InputMediaPhoto[]|InputMediaVideo[] $media A JSON-serialized array describing messages to be sent, must include 2-10 items
     * @param int|string|null $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param bool|null $disable_notification Sends messages {@see https://telegram.org/blog/channels-2-0#silent-messages silently}. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent messages from forwarding and saving
     * @param int|null $reply_to_message_id If the messages are a reply, ID of the original message
     * @param bool|null $allow_sending_without_reply Pass True if the message should be sent even if the specified replied-to message is not found
     * @param ReplyParameters|null $reply_parameters Description of the message to reply to
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param bool|null $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring {@see https://core.telegram.org/bots/faq#how-can-i-message-all-of-my-bot-39s-subscribers-at-once broadcasting limits} for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @param array $clientOpt Client options
     * @return Message[]|null
     */
    public function sendMediaGroup(
        array $media,
        int|string|null $chat_id = null,
        ?int $message_thread_id = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
        ?int $reply_to_message_id = null,
        ?bool $allow_sending_without_reply = null,
        ?ReplyParameters $reply_parameters = null,
        ?string $business_connection_id = null,
        ?string $message_effect_id = null,
        ?bool $allow_paid_broadcast = null,
        array $clientOpt = [],
    ): ?array {
        $chat_id ??= $this->chatId();
        $message_thread_id ??= $this->messageThreadId();
        $business_connection_id ??= $this->businessConnectionId();

        return $this->requestMultipart(__FUNCTION__, [
            'media' => new UploadableArray($media),
            ...compact(
                'chat_id',
                'message_thread_id',
                'disable_notification',
                'protect_content',
                'reply_to_message_id',
                'allow_sending_without_reply',
                'reply_parameters',
                'business_connection_id',
                'message_effect_id',
                'allow_paid_broadcast',
            ),
        ], Message::class, $clientOpt);
    }

    /**
     * Use this method to send point on the map.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * @see https://core.telegram.org/bots/api#sendlocation
     * @param float $latitude Latitude of the location
     * @param float $longitude Longitude of the location
     * @param int|string|null $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param float|null $horizontal_accuracy The radius of uncertainty for the location, measured in meters; 0-1500
     * @param int|null $live_period Period in seconds for which the location will be updated (see {@see https://telegram.org/blog/live-locations Live Locations}, should be between 60 and 86400, or 0x7FFFFFFF for live locations that can be edited indefinitely.
     * @param int|null $heading For live locations, a direction in which the user is moving, in degrees. Must be between 1 and 360 if specified.
     * @param int|null $proximity_alert_radius For live locations, a maximum distance for proximity alerts about approaching another chat member, in meters. Must be between 1 and 100000 if specified.
     * @param bool|null $disable_notification Sends the message {@see https://telegram.org/blog/channels-2-0#silent-messages silently}. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param int|null $reply_to_message_id If the message is a reply, ID of the original message
     * @param bool|null $allow_sending_without_reply Pass True if the message should be sent even if the specified replied-to message is not found
     * @param ReplyParameters|null $reply_parameters Description of the message to reply to
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}, {@see https://core.telegram.org/bots/features#keyboards custom reply keyboard}, instructions to remove reply keyboard or to force a reply from the user.
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param bool|null $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring {@see https://core.telegram.org/bots/faq#how-can-i-message-all-of-my-bot-39s-subscribers-at-once broadcasting limits} for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @return Message|null
     */
    public function sendLocation(
        float $latitude,
        float $longitude,
        int|string|null $chat_id = null,
        ?int $message_thread_id = null,
        ?float $horizontal_accuracy = null,
        ?int $live_period = null,
        ?int $heading = null,
        ?int $proximity_alert_radius = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
        ?int $reply_to_message_id = null,
        ?bool $allow_sending_without_reply = null,
        ?ReplyParameters $reply_parameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
        ?string $business_connection_id = null,
        ?string $message_effect_id = null,
        ?bool $allow_paid_broadcast = null,
    ): ?Message {
        $chat_id ??= $this->chatId();
        $message_thread_id ??= $this->messageThreadId();
        $business_connection_id ??= $this->businessConnectionId();

        return $this->requestJson(__FUNCTION__, compact(
            'chat_id',
            'message_thread_id',
            'latitude',
            'longitude',
            'horizontal_accuracy',
            'live_period',
            'heading',
            'proximity_alert_radius',
            'disable_notification',
            'protect_content',
            'reply_to_message_id',
            'allow_sending_without_reply',
            'reply_parameters',
            'reply_markup',
            'business_connection_id',
            'message_effect_id',
            'allow_paid_broadcast',
        ), Message::class);
    }

    /**
     * Use this method to stop updating a live location message before live_period expires.
     * On success, if the message is not an inline message, the edited {@see https://core.telegram.org/bots/api#message Message} is returned, otherwise True is returned.
     * @see https://core.telegram.org/bots/api#stopmessagelivelocation
     * @param int|string|null $chat_id Required if inline_message_id is not specified. Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int|null $message_id Required if inline_message_id is not specified. Identifier of the message with live location to stop
     * @param string|null $inline_message_id Required if chat_id and message_id are not specified. Identifier of the inline message
     * @param InlineKeyboardMarkup|null $reply_markup A JSON-serialized object for a new {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}.
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message to be edited was sent
     * @return Message|bool|null
     */
    public function stopMessageLiveLocation(
        int|string|null $chat_id = null,
        ?int $message_id = null,
        ?string $inline_message_id = null,
        ?InlineKeyboardMarkup $reply_markup = null,
        ?string $business_connection_id = null,
    ): Message|bool|null {
        $parameters = compact(
            'chat_id',
            'message_id',
            'inline_message_id',
            'reply_markup',
            'business_connection_id',
        );

        $this->setChatMessageOrInlineMessageId($parameters);
        return $this->requestJson(__FUNCTION__, $parameters, Message::class);
    }

    /**
     * Use this method to send information about a venue.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * @see https://core.telegram.org/bots/api#sendvenue
     * @param float $latitude Latitude of the venue
     * @param float $longitude Longitude of the venue
     * @param string $title Name of the venue
     * @param string $address Address of the venue
     * @param int|string|null $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param string|null $foursquare_id Foursquare identifier of the venue
     * @param string|null $foursquare_type Foursquare type of the venue, if known. (For example, “arts_entertainment/default”, “arts_entertainment/aquarium” or “food/icecream”.)
     * @param string|null $google_place_id Google Places identifier of the venue
     * @param string|null $google_place_type Google Places type of the venue. (See {@see https://developers.google.com/places/web-service/supported_types supported types}.)
     * @param bool|null $disable_notification Sends the message {@see https://telegram.org/blog/channels-2-0#silent-messages silently}. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param int|null $reply_to_message_id If the message is a reply, ID of the original message
     * @param bool|null $allow_sending_without_reply Pass True if the message should be sent even if the specified replied-to message is not found
     * @param ReplyParameters|null $reply_parameters Description of the message to reply to
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}, {@see https://core.telegram.org/bots/features#keyboards custom reply keyboard}, instructions to remove reply keyboard or to force a reply from the user.
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param bool|null $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring {@see https://core.telegram.org/bots/faq#how-can-i-message-all-of-my-bot-39s-subscribers-at-once broadcasting limits} for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @return Message|null
     */
    public function sendVenue(
        float $latitude,
        float $longitude,
        string $title,
        string $address,
        int|string|null $chat_id = null,
        ?int $message_thread_id = null,
        ?string $foursquare_id = null,
        ?string $foursquare_type = null,
        ?string $google_place_id = null,
        ?string $google_place_type = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
        ?int $reply_to_message_id = null,
        ?bool $allow_sending_without_reply = null,
        ?ReplyParameters $reply_parameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
        ?string $business_connection_id = null,
        ?string $message_effect_id = null,
        ?bool $allow_paid_broadcast = null,
    ): ?Message {
        $chat_id ??= $this->chatId();
        $message_thread_id ??= $this->messageThreadId();
        $business_connection_id ??= $this->businessConnectionId();

        return $this->requestJson(__FUNCTION__, compact(
            'chat_id',
            'message_thread_id',
            'latitude',
            'longitude',
            'title',
            'address',
            'foursquare_id',
            'foursquare_type',
            'google_place_id',
            'google_place_type',
            'disable_notification',
            'protect_content',
            'reply_to_message_id',
            'allow_sending_without_reply',
            'reply_parameters',
            'reply_markup',
            'business_connection_id',
            'message_effect_id',
            'allow_paid_broadcast',
        ), Message::class);
    }

    /**
     * Use this method to send phone contacts.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * @see https://core.telegram.org/bots/api#sendcontact
     * @param string $phone_number Contact's phone number
     * @param string $first_name Contact's first name
     * @param int|string|null $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param string|null $last_name Contact's last name
     * @param string|null $vcard Additional data about the contact in the form of a {@see https://en.wikipedia.org/wiki/VCard vCard}, 0-2048 bytes
     * @param bool|null $disable_notification Sends the message {@see https://telegram.org/blog/channels-2-0#silent-messages silently}. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param int|null $reply_to_message_id If the message is a reply, ID of the original message
     * @param bool|null $allow_sending_without_reply Pass True if the message should be sent even if the specified replied-to message is not found
     * @param ReplyParameters|null $reply_parameters Description of the message to reply to
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}, {@see https://core.telegram.org/bots/features#keyboards custom reply keyboard}, instructions to remove reply keyboard or to force a reply from the user.
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param bool|null $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring {@see https://core.telegram.org/bots/faq#how-can-i-message-all-of-my-bot-39s-subscribers-at-once broadcasting limits} for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @return Message|null
     */
    public function sendContact(
        string $phone_number,
        string $first_name,
        int|string|null $chat_id = null,
        ?int $message_thread_id = null,
        ?string $last_name = null,
        ?string $vcard = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
        ?int $reply_to_message_id = null,
        ?bool $allow_sending_without_reply = null,
        ?ReplyParameters $reply_parameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
        ?string $business_connection_id = null,
        ?string $message_effect_id = null,
        ?bool $allow_paid_broadcast = null,
    ): ?Message {
        $chat_id ??= $this->chatId();
        $message_thread_id ??= $this->messageThreadId();
        $business_connection_id ??= $this->businessConnectionId();

        return $this->requestJson(__FUNCTION__, compact(
            'chat_id',
            'message_thread_id',
            'phone_number',
            'first_name',
            'last_name',
            'vcard',
            'disable_notification',
            'protect_content',
            'reply_to_message_id',
            'allow_sending_without_reply',
            'reply_parameters',
            'reply_markup',
            'business_connection_id',
            'message_effect_id',
            'allow_paid_broadcast',
        ), Message::class);
    }

    /**
     * Use this method to send a native poll.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * @see https://core.telegram.org/bots/api#sendpoll
     * @param string $question Poll question, 1-300 characters
     * @param InputPollOption[]|string[] $options A JSON-serialized list of answer options, 2-10 strings 1-100 characters each
     * @param int|string|null $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param bool|null $is_anonymous True, if the poll needs to be anonymous, defaults to True
     * @param PollType|string|null $type Poll type, “quiz” or “regular”, defaults to “regular”
     * @param bool|null $allows_multiple_answers True, if the poll allows multiple answers, ignored for polls in quiz mode, defaults to False
     * @param int|null $correct_option_id 0-based identifier of the correct answer option, required for polls in quiz mode
     * @param string|null $explanation Text that is shown when a user chooses an incorrect answer or taps on the lamp icon in a quiz-style poll, 0-200 characters with at most 2 line feeds after entities parsing
     * @param ParseMode|string|null $explanation_parse_mode Mode for parsing entities in the explanation. See {@see https://core.telegram.org/bots/api#formatting-options formatting options} for more details.
     * @param MessageEntity[]|null $explanation_entities A JSON-serialized list of special entities that appear in the poll explanation, which can be specified instead of parse_mode
     * @param int|null $open_period Amount of time in seconds the poll will be active after creation, 5-600. Can't be used together with close_date.
     * @param int|null $close_date Point in time (Unix timestamp) when the poll will be automatically closed. Must be at least 5 and no more than 600 seconds in the future. Can't be used together with open_period.
     * @param bool|null $is_closed Pass True if the poll needs to be immediately closed. This can be useful for poll preview.
     * @param bool|null $disable_notification Sends the message {@see https://telegram.org/blog/channels-2-0#silent-messages silently}. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param int|null $reply_to_message_id If the message is a reply, ID of the original message
     * @param bool|null $allow_sending_without_reply Pass True if the message should be sent even if the specified replied-to message is not found
     * @param ReplyParameters|null $reply_parameters Description of the message to reply to
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}, {@see https://core.telegram.org/bots/features#keyboards custom reply keyboard}, instructions to remove reply keyboard or to force a reply from the user.
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param ParseMode|string|null $question_parse_mode Mode for parsing entities in the question. See {@see https://core.telegram.org/bots/api#formatting-options formatting options} for more details. Currently, only custom emoji entities are allowed.
     * @param MessageEntity[]|null $question_entities A JSON-serialized list of special entities that appear in the poll question. It can be specified instead of question_parse_mode
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param bool|null $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring {@see https://core.telegram.org/bots/faq#how-can-i-message-all-of-my-bot-39s-subscribers-at-once broadcasting limits} for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @return Message|null
     */
    public function sendPoll(
        string $question,
        array $options,
        int|string|null $chat_id = null,
        ?int $message_thread_id = null,
        ?bool $is_anonymous = null,
        PollType|string|null $type = null,
        ?bool $allows_multiple_answers = null,
        ?int $correct_option_id = null,
        ?string $explanation = null,
        ParseMode|string|null $explanation_parse_mode = null,
        ?array $explanation_entities = null,
        ?int $open_period = null,
        ?int $close_date = null,
        ?bool $is_closed = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
        ?int $reply_to_message_id = null,
        ?bool $allow_sending_without_reply = null,
        ?ReplyParameters $reply_parameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
        ?string $business_connection_id = null,
        ParseMode|string|null $question_parse_mode = null,
        ?array $question_entities = null,
        ?string $message_effect_id = null,
        ?bool $allow_paid_broadcast = null,
    ): ?Message {
        $chat_id ??= $this->chatId();
        $message_thread_id ??= $this->messageThreadId();
        $business_connection_id ??= $this->businessConnectionId();
        $parameters = compact(
            'chat_id',
            'message_thread_id',
            'question',
            'is_anonymous',
            'type',
            'allows_multiple_answers',
            'correct_option_id',
            'explanation',
            'explanation_parse_mode',
            'explanation_entities',
            'open_period',
            'close_date',
            'is_closed',
            'disable_notification',
            'protect_content',
            'reply_to_message_id',
            'allow_sending_without_reply',
            'reply_parameters',
            'reply_markup',
            'business_connection_id',
            'question_parse_mode',
            'question_entities',
            'message_effect_id',
            'allow_paid_broadcast',
        );
        return $this->requestJson(__FUNCTION__, [
            'options' => json_encode($options, JSON_THROW_ON_ERROR),
            ...$parameters,
        ], Message::class);
    }

    /**
     * Use this method to send an animated emoji that will display a random value.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * @see https://core.telegram.org/bots/api#senddice
     * @param int|string|null $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param DiceEmoji|string|null $emoji Emoji on which the dice throw animation is based. Currently, must be one of “”, “”, “”, “”, “”, or “”. Dice can have values 1-6 for “”, “” and “”, values 1-5 for “” and “”, and values 1-64 for “”. Defaults to “”
     * @param bool|null $disable_notification Sends the message {@see https://telegram.org/blog/channels-2-0#silent-messages silently}. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding
     * @param int|null $reply_to_message_id If the message is a reply, ID of the original message
     * @param bool|null $allow_sending_without_reply Pass True if the message should be sent even if the specified replied-to message is not found
     * @param ReplyParameters|null $reply_parameters Description of the message to reply to
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}, {@see https://core.telegram.org/bots/features#keyboards custom reply keyboard}, instructions to remove reply keyboard or to force a reply from the user.
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param bool|null $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring {@see https://core.telegram.org/bots/faq#how-can-i-message-all-of-my-bot-39s-subscribers-at-once broadcasting limits} for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @return Message|null
     */
    public function sendDice(
        int|string|null $chat_id = null,
        ?int $message_thread_id = null,
        DiceEmoji|string|null $emoji = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
        ?int $reply_to_message_id = null,
        ?bool $allow_sending_without_reply = null,
        ?ReplyParameters $reply_parameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
        ?string $business_connection_id = null,
        ?string $message_effect_id = null,
        ?bool $allow_paid_broadcast = null,
    ): ?Message {
        $chat_id ??= $this->chatId();
        $message_thread_id ??= $this->messageThreadId();
        $business_connection_id ??= $this->businessConnectionId();
        return $this->requestJson(__FUNCTION__, compact(
            'chat_id',
            'message_thread_id',
            'emoji',
            'disable_notification',
            'protect_content',
            'reply_to_message_id',
            'allow_sending_without_reply',
            'reply_parameters',
            'reply_markup',
            'business_connection_id',
            'message_effect_id',
            'allow_paid_broadcast',
        ), Message::class);
    }

    /**
     * Use this method when you need to tell the user that something is happening on the bot's side.
     * The status is set for 5 seconds or less (when a message arrives from your bot, Telegram clients clear its typing status).
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#sendchataction
     * @param ChatAction|string $action Type of action to broadcast. Choose one, depending on what the user is about to receive: typing for {@see https://core.telegram.org/bots/api#sendmessage text messages}, upload_photo for {@see https://core.telegram.org/bots/api#sendphoto photos}, record_video or upload_video for {@see https://core.telegram.org/bots/api#sendvideo videos}, record_voice or upload_voice for {@see https://core.telegram.org/bots/api#sendvoice voice notes}, upload_document for {@see https://core.telegram.org/bots/api#senddocument general files}, choose_sticker for {@see https://core.telegram.org/bots/api#sendsticker stickers}, find_location for {@see https://core.telegram.org/bots/api#sendlocation location data}, record_video_note or upload_video_note for {@see https://core.telegram.org/bots/api#sendvideonote video notes}.
     * @param int|string|null $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int|null $message_thread_id Unique identifier for the target message thread; supergroups only
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the action will be sent
     * @return bool|null
     */
    public function sendChatAction(
        ChatAction|string $action,
        int|string|null $chat_id = null,
        ?int $message_thread_id = null,
        ?string $business_connection_id = null,
    ): ?bool {
        $chat_id ??= $this->chatId();
        $message_thread_id ??= $this->messageThreadId();
        $business_connection_id ??= $this->businessConnectionId();
        return $this->requestJson(__FUNCTION__, compact(
            'chat_id',
            'message_thread_id',
            'action',
            'business_connection_id',
        ));
    }

    /**
     * Use this method to change the chosen reactions on a message.
     * Service messages can't be reacted to.
     * Automatically forwarded messages from a channel to its discussion group have the same available reactions as messages in the channel.
     * In albums, bots must react to the first message.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#setmessagereaction
     * @param ReactionType[]|null $reaction Optional. New list of reaction types to set on the message. Currently, as non-premium users, bots can set up to one reaction per message. A custom emoji reaction can be used if it is either already present on the message or explicitly allowed by chat administrators.
     * @param bool|null $is_big Optional. Pass True to set the reaction with a big animation
     * @param int|string|null $chat_id Unique identifier for the target chat or username of the target channel (in the format [at]channelusername)
     * @param int|null $message_id Identifier of the target message
     * @return bool|null
     */
    public function setMessageReaction(
        ?array $reaction = null,
        ?bool $is_big = null,
        int|string|null $chat_id = null,
        ?int $message_id = null
    ): ?bool {
        $chat_id ??= $this->chatId();
        $message_id ??= $this->messageId();

        return $this->requestJson(__FUNCTION__, compact(
            'chat_id',
            'message_id',
            'reaction',
            'is_big'
        ));
    }

    /**
     * Use this method to get a list of profile pictures for a user.
     * Returns a {@see https://core.telegram.org/bots/api#userprofilephotos UserProfilePhotos} object.
     * @see https://core.telegram.org/bots/api#getuserprofilephotos
     * @param int|null $user_id Unique identifier of the target user
     * @param int|null $offset Sequential number of the first photo to be returned. By default, all photos are returned.
     * @param int|null $limit Limits the number of photos to be retrieved. Values between 1-100 are accepted. Defaults to 100.
     * @return UserProfilePhotos|null
     */
    public function getUserProfilePhotos(
        ?int $user_id = null,
        ?int $offset = null,
        ?int $limit = null,
    ): ?UserProfilePhotos {
        $user_id ??= $this->userId();
        return $this->requestJson(__FUNCTION__, compact(
            'user_id',
            'offset',
            'limit'
        ), UserProfilePhotos::class);
    }

    /**
     * Changes the emoji status for a given user that previously allowed the bot to manage their emoji status via the Mini App method requestEmojiStatusAccess.
     * Returns True on success.
     * @param string|null $emoji_status_custom_emoji_id Custom emoji identifier of the emoji status to set. Pass an empty string to remove the status.
     * @param int|null $emoji_status_expiration_date Expiration date of the emoji status, if any
     * @param int|null $user_id Unique identifier of the target user
     * @return bool|null
     * @see https://core.telegram.org/bots/api#setuseremojistatus
     */
    public function setUserEmojiStatus(
        ?string $emoji_status_custom_emoji_id = null,
        ?int $emoji_status_expiration_date = null,
        ?int $user_id = null,
    ): ?bool {
        $user_id ??= $this->userId();
        $parameters = compact('user_id', 'emoji_status_custom_emoji_id', 'emoji_status_expiration_date');
        return $this->requestJson(__FUNCTION__, $parameters);
    }

    /**
     * Use this method to get basic information about a file and prepare it for downloading.
     * For the moment, bots can download files of up to 20MB in size.
     * On success, a {@see https://core.telegram.org/bots/api#file File} object is returned.
     * The file can then be downloaded via the link https://api.telegram.org/file/bot<token>/<file_path>, where <file_path> is taken from the response.
     * It is guaranteed that the link will be valid for at least 1 hour.
     * When the link expires, a new one can be requested by calling {@see https://core.telegram.org/bots/api#getfile getFile} again.
     * @see https://core.telegram.org/bots/api#getfile
     * @param string $file_id File identifier to get information about
     * @return File|null
     */
    public function getFile(string $file_id): ?File
    {
        return $this->requestJson(__FUNCTION__, compact('file_id'), File::class);
    }

    /**
     * Use this method to ban a user in a group, a supergroup or a channel.
     * In the case of supergroups and channels, the user will not be able to return to the chat on their own using invite links, etc., unless {@see https://core.telegram.org/bots/api#unbanchatmember unbanned} first.
     * The bot must be an administrator in the chat for this to work and must have the appropriate administrator rights.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#banchatmember
     * @param int|string $chat_id Unique identifier for the target group or username of the target supergroup or channel (in the format &#64;channelusername)
     * @param int $user_id Unique identifier of the target user
     * @param int|null $until_date Date when the user will be unbanned, unix time. If user is banned for more than 366 days or less than 30 seconds from the current time they are considered to be banned forever. Applied for supergroups and channels only.
     * @param bool|null $revoke_messages Pass True to delete all messages from the chat for the user that is being removed. If False, the user will be able to see messages in the group that were sent before the user was removed. Always True for supergroups and channels.
     * @return bool|null
     */
    public function banChatMember(
        int|string $chat_id,
        int $user_id,
        ?int $until_date = null,
        ?bool $revoke_messages = null,
    ): ?bool {
        return $this->requestJson(__FUNCTION__, compact(
            'chat_id',
            'user_id',
            'until_date',
            'revoke_messages'
        ));
    }

    /**
     * Use this method to unban a previously banned user in a supergroup or channel.
     * The user will not return to the group or channel automatically, but will be able to join via link, etc.
     * The bot must be an administrator for this to work.
     * By default, this method guarantees that after the call the user is not a member of the chat, but will be able to join it.
     * So if the user is a member of the chat they will also be removed from the chat.
     * If you don't want this, use the parameter only_if_banned.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#unbanchatmember
     * @param int|string $chat_id Unique identifier for the target group or username of the target supergroup or channel (in the format &#64;channelusername)
     * @param int $user_id Unique identifier of the target user
     * @param bool|null $only_if_banned Do nothing if the user is not banned
     * @return bool|null
     */
    public function unbanChatMember(int|string $chat_id, int $user_id, ?bool $only_if_banned = null): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact(
            'chat_id',
            'user_id',
            'only_if_banned'
        ));
    }

    /**
     * Use this method to restrict a user in a supergroup.
     * The bot must be an administrator in the supergroup for this to work and must have the appropriate administrator rights.
     * Pass True for all permissions to lift restrictions from a user.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#restrictchatmember
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format &#64;supergroupusername)
     * @param int $user_id Unique identifier of the target user
     * @param ChatPermissions $permissions A JSON-serialized object for new user permissions
     * @param bool|null $use_independent_chat_permissions Pass True if chat permissions are set independently. Otherwise, the can_send_other_messages and can_add_web_page_previews permissions will imply the can_send_messages, can_send_audios, can_send_documents, can_send_photos, can_send_videos, can_send_video_notes, and can_send_voice_notes permissions; the can_send_polls permission will imply the can_send_messages permission.
     * @param int|null $until_date Date when restrictions will be lifted for the user, unix time. If user is restricted for more than 366 days or less than 30 seconds from the current time, they are considered to be restricted forever
     * @return bool|null
     */
    public function restrictChatMember(
        int|string $chat_id,
        int $user_id,
        ChatPermissions $permissions,
        ?bool $use_independent_chat_permissions = null,
        ?int $until_date = null,
    ): ?bool {
        return $this->requestJson(__FUNCTION__, [
            'permissions' => json_encode($permissions),
            ...compact(
                'chat_id',
                'user_id',
                'use_independent_chat_permissions',
                'until_date'
            ),
        ]);
    }

    /**
     * Use this method to promote or demote a user in a supergroup or a channel.
     * The bot must be an administrator in the chat for this to work and must have the appropriate administrator rights.
     * Pass False for all boolean parameters to demote a user.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#promotechatmember
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int $user_id Unique identifier of the target user
     * @param bool|null $is_anonymous Pass True if the administrator's presence in the chat is hidden
     * @param bool|null $can_manage_chat Pass True if the administrator can access the chat event log, chat statistics, message statistics in channels, see channel members, see anonymous administrators in supergroups and ignore slow mode. Implied by any other administrator privilege
     * @param bool|null $can_post_messages Pass True if the administrator can create channel posts, channels only
     * @param bool|null $can_edit_messages Pass True if the administrator can edit messages of other users and can pin messages, channels only
     * @param bool|null $can_delete_messages Pass True if the administrator can delete messages of other users
     * @param bool|null $can_post_stories Pass True if the administrator can post stories in the channel
     * @param bool|null $can_edit_stories Pass True if the administrator can edit stories posted by other users
     * @param bool|null $can_delete_stories Pass True if the administrator can delete stories posted by other users
     * @param bool|null $can_manage_video_chats Pass True if the administrator can manage video chats
     * @param bool|null $can_restrict_members Pass True if the administrator can restrict, ban or unban chat members
     * @param bool|null $can_promote_members Pass True if the administrator can add new administrators with a subset of their own privileges or demote administrators that they have promoted, directly or indirectly (promoted by administrators that were appointed by him)
     * @param bool|null $can_change_info Pass True if the administrator can change chat title, photo and other settings
     * @param bool|null $can_invite_users Pass True if the administrator can invite new users to the chat
     * @param bool|null $can_pin_messages Pass True if the administrator can pin messages, supergroups only
     * @param bool|null $can_manage_topics Pass True if the user is allowed to create, rename, close, and reopen forum topics, supergroups only
     * @return bool|null
     */
    public function promoteChatMember(
        int|string $chat_id,
        int $user_id,
        ?bool $is_anonymous = null,
        ?bool $can_manage_chat = null,
        ?bool $can_post_messages = null,
        ?bool $can_edit_messages = null,
        ?bool $can_delete_messages = null,
        ?bool $can_post_stories = null,
        ?bool $can_edit_stories = null,
        ?bool $can_delete_stories = null,
        ?bool $can_manage_video_chats = null,
        ?bool $can_restrict_members = null,
        ?bool $can_promote_members = null,
        ?bool $can_change_info = null,
        ?bool $can_invite_users = null,
        ?bool $can_pin_messages = null,
        ?bool $can_manage_topics = null,
    ): ?bool {
        return $this->requestJson(__FUNCTION__, compact(
            'chat_id',
            'user_id',
            'is_anonymous',
            'can_manage_chat',
            'can_post_messages',
            'can_edit_messages',
            'can_delete_messages',
            'can_post_stories',
            'can_edit_stories',
            'can_delete_stories',
            'can_manage_video_chats',
            'can_restrict_members',
            'can_promote_members',
            'can_change_info',
            'can_invite_users',
            'can_pin_messages',
            'can_manage_topics'
        ));
    }

    /**
     * Use this method to set a custom title for an administrator in a supergroup promoted by the bot.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#setchatadministratorcustomtitle
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format &#64;supergroupusername)
     * @param int $user_id Unique identifier of the target user
     * @param string $custom_title New custom title for the administrator; 0-16 characters, emoji are not allowed
     * @return bool|null
     */
    public function setChatAdministratorCustomTitle(int|string $chat_id, int $user_id, string $custom_title): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact(
            'chat_id',
            'user_id',
            'custom_title'
        ));
    }

    /**
     * Use this method to ban a channel chat in a supergroup or a channel.
     * Until the chat is {@see https://core.telegram.org/bots/api#unbanchatsenderchat unbanned}, the owner of the banned chat won't be able to send messages on behalf of any of their channels.
     * The bot must be an administrator in the supergroup or channel for this to work and must have the appropriate administrator rights.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#banchatsenderchat
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int $sender_chat_id Unique identifier of the target sender chat
     * @return bool|null
     */
    public function banChatSenderChat(int|string $chat_id, int $sender_chat_id): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact(
            'chat_id',
            'sender_chat_id'
        ));
    }

    /**
     * Use this method to unban a previously banned channel chat in a supergroup or channel.
     * The bot must be an administrator for this to work and must have the appropriate administrator rights.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#unbanchatsenderchat
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int $sender_chat_id Unique identifier of the target sender chat
     * @return bool|null
     */
    public function unbanChatSenderChat(int|string $chat_id, int $sender_chat_id): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id', 'sender_chat_id'));
    }

    /**
     * Use this method to set default chat permissions for all members.
     * The bot must be an administrator in the group or a supergroup for this to work and must have the can_restrict_members administrator rights.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#setchatpermissions
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format &#64;supergroupusername)
     * @param ChatPermissions $permissions A JSON-serialized object for new default chat permissions
     * @param bool|null $use_independent_chat_permissions Pass True if chat permissions are set independently. Otherwise, the can_send_other_messages and can_add_web_page_previews permissions will imply the can_send_messages, can_send_audios, can_send_documents, can_send_photos, can_send_videos, can_send_video_notes, and can_send_voice_notes permissions; the can_send_polls permission will imply the can_send_messages permission.
     * @return bool|null
     */
    public function setChatPermissions(
        int|string $chat_id,
        ChatPermissions $permissions,
        ?bool $use_independent_chat_permissions = null,
    ): ?bool {
        return $this->requestJson(__FUNCTION__, [
            'permissions' => json_encode($permissions),
            ...compact(
                'chat_id',
                'permissions',
                'use_independent_chat_permissions'
            ),
        ]);
    }

    /**
     * Use this method to generate a new primary invite link for a chat;
     * any previously generated primary link is revoked.
     * The bot must be an administrator in the chat for this to work and must have the appropriate administrator rights.
     * Returns the new invite link as String on success.
     * @see https://core.telegram.org/bots/api#exportchatinvitelink
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @return string|null
     */
    public function exportChatInviteLink(int|string $chat_id): ?string
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id'));
    }

    /**
     * Use this method to create an additional invite link for a chat.
     * The bot must be an administrator in the chat for this to work and must have the appropriate administrator rights.
     * The link can be revoked using the method {@see https://core.telegram.org/bots/api#revokechatinvitelink revokeChatInviteLink}core.telegram.org/bots/api#chatinvitelink ChatInviteLink}.
     * Returns the new invite link as ChatInviteLink object.
     * @see https://core.telegram.org/bots/api#createchatinvitelink
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param string|null $name Invite link name; 0-32 characters
     * @param int|null $expire_date Point in time (Unix timestamp) when the link will expire
     * @param int|null $member_limit The maximum number of users that can be members of the chat simultaneously after joining the chat via this invite link; 1-99999
     * @param bool|null $creates_join_request True, if users joining the chat via the link need to be approved by chat administrators. If True, member_limit can't be specified
     * @return ChatInviteLink|null
     */
    public function createChatInviteLink(
        int|string $chat_id,
        ?string $name = null,
        ?int $expire_date = null,
        ?int $member_limit = null,
        ?bool $creates_join_request = null,
    ): ?ChatInviteLink {
        return $this->requestJson(__FUNCTION__, compact(
            'chat_id',
            'name',
            'expire_date',
            'member_limit',
            'creates_join_request'
        ), ChatInviteLink::class);
    }

    /**
     * Use this method to edit a non-primary invite link created by the bot.
     * The bot must be an administrator in the chat for this to work and must have the appropriate administrator rights.
     * Returns the edited invite link as a {@see https://core.telegram.org/bots/api#chatinvitelink ChatInviteLink} object.
     * @see https://core.telegram.org/bots/api#editchatinvitelink
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param string $invite_link The invite link to edit
     * @param string|null $name Invite link name; 0-32 characters
     * @param int|null $expire_date Point in time (Unix timestamp) when the link will expire
     * @param int|null $member_limit The maximum number of users that can be members of the chat simultaneously after joining the chat via this invite link; 1-99999
     * @param bool|null $creates_join_request True, if users joining the chat via the link need to be approved by chat administrators. If True, member_limit can't be specified
     * @return ChatInviteLink|null
     */
    public function editChatInviteLink(
        int|string $chat_id,
        string $invite_link,
        ?string $name = null,
        ?int $expire_date = null,
        ?int $member_limit = null,
        ?bool $creates_join_request = null,
    ): ?ChatInviteLink {
        return $this->requestJson(__FUNCTION__, compact(
            'chat_id',
            'invite_link',
            'name',
            'expire_date',
            'member_limit',
            'creates_join_request'
        ), ChatInviteLink::class);
    }

    /**
     * Use this method to create a
     * {@see https://telegram.org/blog/superchannels-star-reactions-subscriptions#star-subscriptions subscription invite link}
     * for a channel chat.
     * The bot must have the can_invite_users administrator rights.
     * The link can be edited using the method
     * {@see https://core.telegram.org/bots/api#editchatsubscriptioninvitelink editChatSubscriptionInviteLink}
     * or revoked using the method {@see https://core.telegram.org/bots/api#revokechatinvitelink revokeChatInviteLink}.
     * Returns the new invite link as a {@see https://core.telegram.org/bots/api#chatinvitelink ChatInviteLink} object.
     * @see https://core.telegram.org/bots/api#createchatsubscriptioninvitelink
     * @param string|int $chat_id Unique identifier for the target channel chat or username of the target channel (in the format &#64;channelusername)
     * @param int $subscription_period The number of seconds the subscription will be active for before the next payment. Currently, it must always be 2592000 (30 days).
     * @param int $subscription_price The amount of Telegram Stars a user must pay initially and after each subsequent subscription period to be a member of the chat; 1-2500
     * @param string|null $name Invite link name; 0-32 characters
     * @return ChatInviteLink|null
     */
    public function createChatSubscriptionInviteLink(
        string|int $chat_id,
        int $subscription_period,
        int $subscription_price,
        ?string $name = null,
    ): ?ChatInviteLink {
        return $this->requestJson(__FUNCTION__, compact(
            'chat_id',
            'subscription_period',
            'subscription_price',
            'name',
        ), ChatInviteLink::class);
    }

    /**
     * Use this method to edit a subscription invite link created by the bot.
     * The bot must have the can_invite_users administrator rights.
     * Returns the edited invite link as a {@see https://core.telegram.org/bots/api#chatinvitelink ChatInviteLink} object.
     * @see https://core.telegram.org/bots/api#editchatsubscriptioninvitelink
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param string $invite_link The invite link to edit
     * @param string|null $name Invite link name; 0-32 characters
     * @return ChatInviteLink|null
     */
    public function editChatSubscriptionInviteLink(
        int|string $chat_id,
        string $invite_link,
        ?string $name = null,
    ): ?ChatInviteLink {
        return $this->requestJson(__FUNCTION__, compact(
            'chat_id',
            'invite_link',
            'name',
        ), ChatInviteLink::class);
    }

    /**
     * Use this method to revoke an invite link created by the bot.
     * If the primary link is revoked, a new link is automatically generated.
     * The bot must be an administrator in the chat for this to work and must have the appropriate administrator rights.
     * Returns the revoked invite link as {@see https://core.telegram.org/bots/api#chatinvitelink ChatInviteLink} object.
     * @see https://core.telegram.org/bots/api#revokechatinvitelink
     * @param int|string $chat_id Unique identifier of the target chat or username of the target channel (in the format &#64;channelusername)
     * @param string $invite_link The invite link to revoke
     * @return ChatInviteLink|null
     */
    public function revokeChatInviteLink(int|string $chat_id, string $invite_link): ?ChatInviteLink
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id', 'invite_link'), ChatInviteLink::class);
    }

    /**
     * Use this method to approve a chat join request.
     * The bot must be an administrator in the chat for this to work and must have the can_invite_users administrator right.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#approvechatjoinrequest
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int $user_id Unique identifier of the target user
     * @return bool|null
     */
    public function approveChatJoinRequest(int|string $chat_id, int $user_id): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id', 'user_id'));
    }

    /**
     * Use this method to decline a chat join request.
     * The bot must be an administrator in the chat for this to work and must have the can_invite_users administrator right.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#declinechatjoinrequest
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int $user_id Unique identifier of the target user
     * @return bool|null
     */
    public function declineChatJoinRequest(int|string $chat_id, int $user_id): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id', 'user_id'));
    }

    /**
     * Use this method to set a new profile photo for the chat.
     * Photos can't be changed for private chats.
     * The bot must be an administrator in the chat for this to work and must have the appropriate administrator rights.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#setchatphoto
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param InputFile $photo New chat photo, uploaded using multipart/form-data
     * @param array $clientOpt Client options
     * @return bool|null
     */
    public function setChatPhoto(int|string $chat_id, InputFile $photo, array $clientOpt = []): ?bool
    {
        return $this->requestMultipart(__FUNCTION__, compact('chat_id', 'photo'), options: $clientOpt);
    }

    /**
     * Use this method to delete a chat photo.
     * Photos can't be changed for private chats.
     * The bot must be an administrator in the chat for this to work and must have the appropriate administrator rights.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#deletechatphoto
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @return bool|null
     */
    public function deleteChatPhoto(int|string $chat_id): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id'));
    }

    /**
     * Use this method to change the title of a chat.
     * Titles can't be changed for private chats.
     * The bot must be an administrator in the chat for this to work and must have the appropriate administrator rights.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#setchattitle
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param string $title New chat title, 1-128 characters
     * @return bool|null
     */
    public function setChatTitle(int|string $chat_id, string $title): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id', 'title'));
    }

    /**
     * Use this method to change the description of a group, a supergroup or a channel.
     * The bot must be an administrator in the chat for this to work and must have the appropriate administrator rights.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#setchatdescription
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param string|null $description New chat description, 0-255 characters
     * @return bool|null
     */
    public function setChatDescription(int|string $chat_id, ?string $description = null): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id', 'description'));
    }

    /**
     * Use this method to add a message to the list of pinned messages in a chat.
     * If the chat is not a private chat, the bot must be an administrator in the chat for this to work and must have the 'can_pin_messages' administrator right in a supergroup or 'can_edit_messages' administrator right in a channel.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#pinchatmessage
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int $message_id Identifier of a message to pin
     * @param bool|null $disable_notification Pass True if it is not necessary to send a notification to all chat members about the new pinned message. Notifications are always disabled in channels and private chats.
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be pinned
     * @return bool|null
     */
    public function pinChatMessage(
        int|string $chat_id,
        int $message_id,
        ?bool $disable_notification = null,
        ?string $business_connection_id = null,
    ): ?bool {
        $business_connection_id ??= $this->businessConnectionId();
        return $this->requestJson(__FUNCTION__, compact('chat_id', 'message_id', 'disable_notification', 'business_connection_id'));
    }

    /**
     * Use this method to remove a message from the list of pinned messages in a chat.
     * If the chat is not a private chat, the bot must be an administrator in the chat for this to work and must have the 'can_pin_messages' administrator right in a supergroup or 'can_edit_messages' administrator right in a channel.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#unpinchatmessage
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int|null $message_id Identifier of a message to unpin. If not specified, the most recent pinned message (by sending date) will be unpinned.
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be pinned
     * @return bool|null
     */
    public function unpinChatMessage(
        int|string $chat_id,
        ?int $message_id = null,
        ?string $business_connection_id = null,
    ): ?bool {
        $business_connection_id ??= $this->businessConnectionId();
        return $this->requestJson(__FUNCTION__, compact('chat_id', 'message_id', 'business_connection_id'));
    }

    /**
     * Use this method to clear the list of pinned messages in a chat.
     * If the chat is not a private chat, the bot must be an administrator in the chat for this to work and must have the 'can_pin_messages' administrator right in a supergroup or 'can_edit_messages' administrator right in a channel.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#unpinallchatmessages
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @return bool|null
     */
    public function unpinAllChatMessages(int|string $chat_id): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id'));
    }

    /**
     * Use this method for your bot to leave a group, supergroup or channel.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#leavechat
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup or channel (in the format &#64;channelusername)
     * @return bool|null
     */
    public function leaveChat(int|string $chat_id): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id'));
    }

    /**
     * Use this method to get up to date information about the chat (current name of the user for one-on-one conversations, current username of a user, group or channel, etc.).
     * Returns a {@see https://core.telegram.org/bots/api#chat Chat} object on success.
     * @see https://core.telegram.org/bots/api#getchat
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup or channel (in the format &#64;channelusername)
     * @return Chat|null
     */
    public function getChat(int|string $chat_id): ?Chat
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id'), Chat::class);
    }

    /**
     * Use this method to get a list of administrators in a chat, which aren't bots.
     * Returns an Array of {@see https://core.telegram.org/bots/api#chatmember ChatMember} objects.
     * @see https://core.telegram.org/bots/api#getchatadministrators
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup or channel (in the format &#64;channelusername)
     * @return ChatMember[]|null
     */
    public function getChatAdministrators(int|string $chat_id): ?array
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id'), ChatMember::class);
    }

    /**
     * Use this method to get the number of members in a chat.
     * Returns Int on success.
     * @see https://core.telegram.org/bots/api#getchatmembercount
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup or channel (in the format &#64;channelusername)
     * @return int|null
     */
    public function getChatMemberCount(int|string $chat_id): ?int
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id'));
    }

    /**
     * Use this method to get information about a member of a chat.
     * The method is only guaranteed to work for other users if the bot is an administrator in the chat.
     * Returns a {@see https://core.telegram.org/bots/api#chatmember ChatMember} object on success.
     * @see https://core.telegram.org/bots/api#getchatmember
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup or channel (in the format &#64;channelusername)
     * @param int $user_id Unique identifier of the target user
     * @return ChatMember|null
     */
    public function getChatMember(int|string $chat_id, int $user_id): ?ChatMember
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id', 'user_id'), ChatMember::class);
    }

    /**
     * Use this method to set a new group sticker set for a supergroup.
     * The bot must be an administrator in the chat for this to work and must have the appropriate administrator rights.
     * Use the field can_set_sticker_set optionally returned in {@see https://core.telegram.org/bots/api#getchat getChat} requests to check if the bot can use this method.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#setchatstickerset
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format &#64;supergroupusername)
     * @param string $sticker_set_name Name of the sticker set to be set as the group sticker set
     * @return bool|null
     */
    public function setChatStickerSet(int|string $chat_id, string $sticker_set_name): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id', 'sticker_set_name'));
    }

    /**
     * Use this method to delete a group sticker set from a supergroup.
     * The bot must be an administrator in the chat for this to work and must have the appropriate administrator rights.
     * Use the field can_set_sticker_set optionally returned in {@see https://core.telegram.org/bots/api#getchat getChat} requests to check if the bot can use this method.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#deletechatstickerset
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format &#64;supergroupusername)
     * @return bool|null
     */
    public function deleteChatStickerSet(int|string $chat_id): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id'));
    }

    /**
     * Use this method to get custom emoji stickers, which can be used as a forum topic icon by any user.
     * Requires no parameters.
     * Returns an Array of {@see https://core.telegram.org/bots/api#sticker Sticker} objects.
     * @see https://core.telegram.org/bots/api#getforumtopiciconstickers
     * @return Sticker[]|null
     */
    public function getForumTopicIconStickers(): ?array
    {
        return $this->requestJson(__FUNCTION__, mapTo: Sticker::class);
    }

    /**
     * Use this method to create a topic in a forum supergroup chat.
     * The bot must be an administrator in the chat for this to work and must have the can_manage_topics administrator rights.
     * Returns information about the created topic as a {@see https://core.telegram.org/bots/api#forumtopic ForumTopic} object.
     * @see https://core.telegram.org/bots/api#createforumtopic
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format &#64;supergroupusername)
     * @param string $name Topic name, 1-128 characters
     * @param ForumIconColor|int|null $icon_color Color of the topic icon in RGB format. Currently, must be one of 7322096 (0x6FB9F0), 16766590 (0xFFD67E), 13338331 (0xCB86DB), 9367192 (0x8EEE98), 16749490 (0xFF93B2), or 16478047 (0xFB6F5F)
     * @param string|null $icon_custom_emoji_id Unique identifier of the custom emoji shown as the topic icon. Use {@see https://core.telegram.org/bots/api#getforumtopiciconstickers getForumTopicIconStickers} to get all allowed custom emoji identifiers.
     * @return ForumTopic|null
     */
    public function createForumTopic(
        int|string $chat_id,
        string $name,
        ForumIconColor|int|null $icon_color = null,
        ?string $icon_custom_emoji_id = null,
    ): ?ForumTopic {
        $parameters = compact('chat_id', 'name', 'icon_color', 'icon_custom_emoji_id');
        return $this->requestJson(__FUNCTION__, $parameters, ForumTopic::class);
    }

    /**
     * Use this method to edit name and icon of a topic in a forum supergroup chat.
     * The bot must be an administrator in the chat for this to work and must have can_manage_topics administrator rights, unless it is the creator of the topic.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#editforumtopic
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format &#64;supergroupusername)
     * @param int $message_thread_id Unique identifier for the target message thread of the forum topic
     * @param string|null $name New topic name, 0-128 characters. If not specified or empty, the current name of the topic will be kept
     * @param string|null $icon_custom_emoji_id New unique identifier of the custom emoji shown as the topic icon. Use {@see https://core.telegram.org/bots/api#getforumtopiciconstickers getForumTopicIconStickers} to get all allowed custom emoji identifiers. Pass an empty string to remove the icon. If not specified, the current icon will be kept
     * @return bool|null
     */
    public function editForumTopic(
        int|string $chat_id,
        int $message_thread_id,
        ?string $name = null,
        ?string $icon_custom_emoji_id = null,
    ): ?bool {
        $parameters = compact('chat_id', 'message_thread_id', 'name', 'icon_custom_emoji_id');
        return $this->requestJson(__FUNCTION__, $parameters);
    }

    /**
     * Use this method to close an open topic in a forum supergroup chat.
     * The bot must be an administrator in the chat for this to work and must have the can_manage_topics administrator rights, unless it is the creator of the topic.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#closeforumtopic
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format &#64;supergroupusername)
     * @param int $message_thread_id Unique identifier for the target message thread of the forum topic
     * @return bool|null
     */
    public function closeForumTopic(int|string $chat_id, int $message_thread_id): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id', 'message_thread_id'));
    }

    /**
     * Use this method to reopen a closed topic in a forum supergroup chat.
     * The bot must be an administrator in the chat for this to work and must have the can_manage_topics administrator rights, unless it is the creator of the topic.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#reopenforumtopic
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format &#64;supergroupusername)
     * @param int $message_thread_id Unique identifier for the target message thread of the forum topic
     * @return bool|null
     */
    public function reopenForumTopic(int|string $chat_id, int $message_thread_id): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id', 'message_thread_id'));
    }

    /**
     * Use this method to delete a forum topic along with all its messages in a forum supergroup chat.
     * The bot must be an administrator in the chat for this to work and must have the can_delete_messages administrator rights.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#deleteforumtopic
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format &#64;supergroupusername)
     * @param int $message_thread_id Unique identifier for the target message thread of the forum topic
     * @return bool|null
     */
    public function deleteForumTopic(int|string $chat_id, int $message_thread_id): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id', 'message_thread_id'));
    }

    /**
     * Use this method to clear the list of pinned messages in a forum topic.
     * The bot must be an administrator in the chat for this to work and must have the can_pin_messages administrator right in the supergroup.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#unpinallforumtopicmessages
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format &#64;supergroupusername)
     * @param int $message_thread_id Unique identifier for the target message thread of the forum topic
     * @return bool|null
     */
    public function unpinAllForumTopicMessages(int|string $chat_id, int $message_thread_id): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id', 'message_thread_id'));
    }

    /**
     * Use this method to edit the name of the 'General' topic in a forum supergroup chat.
     * The bot must be an administrator in the chat for this to work and must have can_manage_topics administrator rights.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#editgeneralforumtopic
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format &#64;supergroupusername)
     * @param string $name New topic name, 1-128 characters
     * @return bool|null
     */
    public function editGeneralForumTopic(int|string $chat_id, string $name): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id', 'name'));
    }

    /**
     * Use this method to close an open 'General' topic in a forum supergroup chat.
     * The bot must be an administrator in the chat for this to work and must have the can_manage_topics administrator rights.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#closegeneralforumtopic
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format &#64;supergroupusername)
     * @return bool|null
     */
    public function closeGeneralForumTopic(int|string $chat_id): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id'));
    }

    /**
     * Use this method to reopen a closed 'General' topic in a forum supergroup chat.
     * The bot must be an administrator in the chat for this to work and must have the can_manage_topics administrator rights.
     * The topic will be automatically unhidden if it was hidden.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#reopengeneralforumtopic
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format &#64;supergroupusername)
     * @return bool|null
     */
    public function reopenGeneralForumTopic(int|string $chat_id): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id'));
    }

    /**
     * Use this method to hide the 'General' topic in a forum supergroup chat.
     * The bot must be an administrator in the chat for this to work and must have the can_manage_topics administrator rights.
     * The topic will be automatically closed if it was open.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#hidegeneralforumtopic
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format &#64;supergroupusername)
     * @return bool|null
     */
    public function hideGeneralForumTopic(int|string $chat_id): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id'));
    }

    /**
     * Use this method to unhide the 'General' topic in a forum supergroup chat.
     * The bot must be an administrator in the chat for this to work and must have the can_manage_topics administrator rights.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#unhidegeneralforumtopic
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format &#64;supergroupusername)
     * @return bool|null
     */
    public function unhideGeneralForumTopic(int|string $chat_id): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id'));
    }

    /**
     * Use this method to send answers to callback queries sent from {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboards}.
     * The answer will be displayed to the user as a notification at the top of the chat screen or as an alert.
     * On success, True is returned.
     * @see https://core.telegram.org/bots/api#answercallbackquery
     * @param string|null $callback_query_id Unique identifier for the query to be answered
     * @param string|null $text Text of the notification. If not specified, nothing will be shown to the user, 0-200 characters
     * @param bool|null $show_alert If True, an alert will be shown by the client instead of a notification at the top of the chat screen. Defaults to false.
     * @param string|null $url URL that will be opened by the user's client. If you have created a {@see https://core.telegram.org/bots/api#game Game} and accepted the conditions via {@see https://t.me/botfather @BotFather}, specify the URL that opens your game - note that this will only work if the query comes from a {@see https://core.telegram.org/bots/api#inlinekeyboardbutton callback_game} button.Otherwise, you may use links like t.me/your_bot?start=XXXX that open your bot with a parameter.
     * @param int|null $cache_time The maximum amount of time in seconds that the result of the callback query may be cached client-side. Telegram apps will support caching starting in version 3.14. Defaults to 0.
     * @return bool|null
     */
    public function answerCallbackQuery(
        ?string $callback_query_id = null,
        ?string $text = null,
        ?bool $show_alert = null,
        ?string $url = null,
        ?int $cache_time = null,
    ): ?bool {
        $callback_query_id ??= $this->callbackQuery()?->id;
        $parameters = compact(
            'callback_query_id',
            'text',
            'show_alert',
            'url',
            'cache_time'
        );

        return $this->requestJson(__FUNCTION__, $parameters);
    }

    /**
     * Use this method to get the list of boosts added to a chat by a user.
     * Requires administrator rights in the chat.
     * Returns a UserChatBoosts object.
     * @see https://core.telegram.org/bots/api#getuserchatboosts
     * @param int|string|null $chat_id Unique identifier for the chat or username of the channel (in the format &#64;channelusername)
     * @param int|null $user_id Unique identifier of the target user
     * @return UserChatBoosts|null
     */
    public function getUserChatBoosts(int|string $chat_id = null, int $user_id = null): ?UserChatBoosts
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id', 'user_id'), UserChatBoosts::class);
    }

    /**
     * Use this method to get information about the connection of the bot with a business account.
     * Returns a {@see https://core.telegram.org/bots/api#businessconnection BusinessConnection} object on success.
     * @see https://core.telegram.org/bots/api#getbusinessconnection
     * @param string $business_connection_id Unique identifier of the business connection
     * @return BusinessConnection|null
     */
    public function getBusinessConnection(string $business_connection_id): ?BusinessConnection
    {
        return $this->requestJson(__FUNCTION__, compact('business_connection_id'), BusinessConnection::class);
    }

    /**
     * Use this method to change the list of the bot's commands.
     * See {@see https://core.telegram.org/bots/features#commands this manual} for more details about bot commands.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#setmycommands
     * @param BotCommand[] $commands A JSON-serialized list of bot commands to be set as the list of the bot's commands. At most 100 commands can be specified.
     * @param BotCommandScope|null $scope A JSON-serialized object, describing scope of users for which the commands are relevant. Defaults to {@see https://core.telegram.org/bots/api#botcommandscopedefault BotCommandScopeDefault}.
     * @param string|null $language_code A two-letter ISO 639-1 language code. If empty, commands will be applied to all users from the given scope, for whose language there are no dedicated commands
     * @return bool|null
     */
    public function setMyCommands(array $commands, ?BotCommandScope $scope = null, ?string $language_code = null): ?bool
    {
        $parameters = compact('commands', 'scope', 'language_code');

        if (array_key_exists('commands', $parameters)) {
            $parameters['commands'] = json_encode($parameters['commands']);
        }

        if (array_key_exists('scope', $parameters)) {
            $parameters['scope'] = json_encode($parameters['scope']);
        }

        return $this->requestJson(__FUNCTION__, $parameters);
    }

    /**
     * Use this method to delete the list of the bot's commands for the given scope and user language.
     * After deletion, {@see https://core.telegram.org/bots/api#determining-list-of-commands higher level commands} will be shown to affected users.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#deletemycommands
     * @param BotCommandScope|null $scope A JSON-serialized object, describing scope of users for which the commands are relevant. Defaults to {@see https://core.telegram.org/bots/api#botcommandscopedefault BotCommandScopeDefault}.
     * @param string|null $language_code A two-letter ISO 639-1 language code. If empty, commands will be applied to all users from the given scope, for whose language there are no dedicated commands
     * @return bool|null
     */
    public function deleteMyCommands(?BotCommandScope $scope = null, ?string $language_code = null): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('scope', 'language_code'));
    }

    /**
     * Use this method to get the current list of the bot's commands for the given scope and user language.
     * Returns an Array of {@see https://core.telegram.org/bots/api#botcommand BotCommand} objects.
     * If commands aren't set, an empty list is returned.
     * @see https://core.telegram.org/bots/api#getmycommands
     * @param BotCommandScope|null $scope A JSON-serialized object, describing scope of users. Defaults to {@see https://core.telegram.org/bots/api#botcommandscopedefault BotCommandScopeDefault}.
     * @param string|null $language_code A two-letter ISO 639-1 language code or an empty string
     * @return BotCommand[]|null
     */
    public function getMyCommands(?BotCommandScope $scope = null, ?string $language_code = null): ?array
    {
        return $this->requestJson(__FUNCTION__, compact('scope', 'language_code'), BotCommand::class);
    }

    /**
     * Use this method to get the current bot name for the given user language.
     * Returns {@see https://core.telegram.org/bots/api#botname BotName} on success.
     * @see https://core.telegram.org/bots/api#getmyname
     * @param string|null $language_code A two-letter ISO 639-1 language code or an empty string
     * @return BotName|null
     */
    public function getMyName(?string $language_code = null): ?BotName
    {
        return $this->requestJson(__FUNCTION__, compact('language_code'), BotName::class);
    }

    /**
     * Use this method to change the bot's name.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#setmyname
     * @param string|null $name New bot name; 0-64 characters. Pass an empty string to remove the dedicated name for the given language.
     * @param string|null $language_code A two-letter ISO 639-1 language code. If empty, the name will be shown to all users for whose language there is no dedicated name.
     * @return bool|null
     */
    public function setMyName(?string $name = null, ?string $language_code = null): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('name', 'language_code'), BotCommand::class);
    }

    /**
     * Use this method to change the bot's description, which is shown in the chat with the bot if the chat is empty.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#setmydescription
     * @param string|null $description New bot description; 0-512 characters. Pass an empty string to remove the dedicated description for the given language.
     * @param string|null $language_code A two-letter ISO 639-1 language code. If empty, the description will be applied to all users for whose language there is no dedicated description.
     * @return bool|null
     */
    public function setMyDescription(?string $description = null, ?string $language_code = null): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('description', 'language_code'));
    }

    /**
     * Use this method to get the current bot description for the given user language.
     * Returns {@see https://core.telegram.org/bots/api#botdescription BotDescription} on success.
     * @see https://core.telegram.org/bots/api#getmydescription
     * @param string|null $language_code A two-letter ISO 639-1 language code or an empty string
     * @return BotDescription|null
     */
    public function getMyDescription(?string $language_code = null): ?BotDescription
    {
        return $this->requestJson(__FUNCTION__, compact('language_code'), BotDescription::class);
    }

    /**
     * Use this method to change the bot's short description, which is shown on the bot's profile page and is sent together with the link when users share the bot.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#setmyshortdescription
     * @param string|null $short_description New short description for the bot; 0-120 characters. Pass an empty string to remove the dedicated short description for the given language.
     * @param string|null $language_code A two-letter ISO 639-1 language code. If empty, the short description will be applied to all users for whose language there is no dedicated short description.
     * @return bool|null
     */
    public function setMyShortDescription(?string $short_description = null, ?string $language_code = null): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('short_description', 'language_code'));
    }

    /**
     * Use this method to get the current bot short description for the given user language.
     * Returns {@see https://core.telegram.org/bots/api#botshortdescription BotShortDescription} on success.
     * @see https://core.telegram.org/bots/api#getmyshortdescription
     * @param string|null $language_code A two-letter ISO 639-1 language code or an empty string
     * @return BotShortDescription|null
     */
    public function getMyShortDescription(?string $language_code = null): ?BotShortDescription
    {
        return $this->requestJson(__FUNCTION__, compact('language_code'), BotShortDescription::class);
    }

    /**
     * Use this method to change the bot's menu button in a private chat, or the default menu button.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#setchatmenubutton
     * @param int|null $chat_id Unique identifier for the target private chat. If not specified, default bot's menu button will be changed
     * @param MenuButton|null $menu_button A JSON-serialized object for the bot's new menu button. Defaults to {@see https://core.telegram.org/bots/api#menubuttondefault MenuButtonDefault}
     * @return bool|null
     */
    public function setChatMenuButton(?int $chat_id = null, ?MenuButton $menu_button = null): ?bool
    {
        $chat_id ??= $this->chatId();
        return $this->requestJson(__FUNCTION__, compact('chat_id', 'menu_button'));
    }

    /**
     * Use this method to get the current value of the bot's menu button in a private chat, or the default menu button.
     * Returns {@see https://core.telegram.org/bots/api#menubutton MenuButton} on success.
     * @see https://core.telegram.org/bots/api#getchatmenubutton
     * @param int|null $chat_id Unique identifier for the target private chat. If not specified, default bot's menu button will be returned
     * @return MenuButton|null
     */
    public function getChatMenuButton(?int $chat_id = null): ?MenuButton
    {
        $chat_id ??= $this->chatId();
        return $this->requestJson(__FUNCTION__, compact('chat_id'), MenuButton::class);
    }

    /**
     * Use this method to change the default administrator rights requested by the bot when it's added as an administrator to groups or channels.
     * These rights will be suggested to users, but they are free to modify the list before adding the bot.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#setmydefaultadministratorrights
     * @param ChatAdministratorRights|null $rights A JSON-serialized object describing new default administrator rights. If not specified, the default administrator rights will be cleared.
     * @param bool|null $for_channels Pass True to change the default administrator rights of the bot in channels. Otherwise, the default administrator rights of the bot for groups and supergroups will be changed.
     * @return bool|null
     */
    public function setMyDefaultAdministratorRights(
        ?ChatAdministratorRights $rights = null,
        ?bool $for_channels = null,
    ): ?bool {
        return $this->requestJson(__FUNCTION__, compact('rights', 'for_channels'));
    }

    /**
     * Use this method to get the current default administrator rights of the bot.
     * Returns {@see https://core.telegram.org/bots/api#chatadministratorrights ChatAdministratorRights} on success.
     * @see https://core.telegram.org/bots/api#getmydefaultadministratorrights
     * @param bool|null $for_channels Pass True to get default administrator rights of the bot in channels. Otherwise, default administrator rights of the bot for groups and supergroups will be returned.
     * @return ChatAdministratorRights|null
     */
    public function getMyDefaultAdministratorRights(?bool $for_channels = null): ?ChatAdministratorRights
    {
        return $this->requestJson(__FUNCTION__, compact('for_channels'), ChatAdministratorRights::class);
    }

    /**
     * Use this method to clear the list of pinned messages in a General forum topic.
     * The bot must be an administrator in the chat for this to work and must have the can_pin_messages administrator right in the supergroup.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#unpinallgeneralforumtopicmessages
     * @param int|string $chat_id Unique identifier for the target chat or username of the target supergroup (in the format &#64;supergroupusername)
     * @return bool|null
     */
    public function unpinAllGeneralForumTopicMessages(int|string $chat_id): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id'));
    }
}
