<?php

namespace SergiX44\Nutgram\Telegram\Endpoints;

use SergiX44\Nutgram\Telegram\Client;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Input\InputMedia;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Message\LinkPreviewOptions;
use SergiX44\Nutgram\Telegram\Types\Message\Message;
use SergiX44\Nutgram\Telegram\Types\Message\MessageEntity;
use SergiX44\Nutgram\Telegram\Types\Poll\Poll;

/**
 * Trait UpdatesMessages
 * @package SergiX44\Nutgram\Telegram
 * @mixin Client
 */
trait UpdatesMessages
{
    /**
     * Use this method to edit text and {@see https://core.telegram.org/bots/api#games game} messages.
     * On success, if the edited message is not an inline message, the edited {@see https://core.telegram.org/bots/api#message Message} is returned, otherwise True is returned.
     * @see https://core.telegram.org/bots/api#editmessagetext
     * @param string $text New text of the message, 1-4096 characters after entities parsing
     * @param int|string|null $chat_id Required if inline_message_id is not specified. Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int|null $message_id Required if inline_message_id is not specified. Identifier of the message to edit
     * @param string|null $inline_message_id Required if chat_id and message_id are not specified. Identifier of the inline message
     * @param ParseMode|string|null $parse_mode Mode for parsing entities in the message text. See {@see https://core.telegram.org/bots/api#formatting-options formatting options} for more details.
     * @param MessageEntity[]|null $entities A JSON-serialized list of special entities that appear in message text, which can be specified instead of parse_mode
     * @param bool|null $disable_web_page_preview Disables link previews for links in this message
     * @param LinkPreviewOptions|null $link_preview_options Link preview generation options for the message
     * @param InlineKeyboardMarkup|null $reply_markup A JSON-serialized object for an {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}.
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message to be edited was sent
     * @return Message|bool|null
     */
    public function editMessageText(
        string $text,
        int|string|null $chat_id = null,
        ?int $message_id = null,
        ?string $inline_message_id = null,
        ParseMode|string|null $parse_mode = null,
        ?array $entities = null,
        ?bool $disable_web_page_preview = null,
        ?LinkPreviewOptions $link_preview_options = null,
        ?InlineKeyboardMarkup $reply_markup = null,
        ?string $business_connection_id = null,
    ): Message|bool|null {
        $parameters = compact(
            'chat_id',
            'message_id',
            'inline_message_id',
            'text',
            'parse_mode',
            'entities',
            'disable_web_page_preview',
            'link_preview_options',
            'reply_markup',
            'business_connection_id',
        );
        $this->setChatMessageOrInlineMessageId($parameters);

        return $this->requestJson(__FUNCTION__, $parameters, Message::class);
    }

    /**
     * Use this method to edit captions of messages.
     * On success, if the edited message is not an inline message, the edited {@see https://core.telegram.org/bots/api#message Message} is returned, otherwise True is returned.
     * @see https://core.telegram.org/bots/api#editmessagecaption
     * @param int|string|null $chat_id Required if inline_message_id is not specified. Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int|null $message_id Required if inline_message_id is not specified. Identifier of the message to edit
     * @param string|null $inline_message_id Required if chat_id and message_id are not specified. Identifier of the inline message
     * @param string|null $caption New caption of the message, 0-1024 characters after entities parsing
     * @param ParseMode|string|null $parse_mode Mode for parsing entities in the message caption. See {@see https://core.telegram.org/bots/api#formatting-options formatting options} for more details.
     * @param MessageEntity[]|null $caption_entities A JSON-serialized list of special entities that appear in the caption, which can be specified instead of parse_mode
     * @param InlineKeyboardMarkup|null $reply_markup A JSON-serialized object for an {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}.
     * @param bool|null $show_caption_above_media Pass True, if the caption must be shown above the message media
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message to be edited was sent
     * @return Message|bool|null
     */
    public function editMessageCaption(
        int|string|null $chat_id = null,
        ?int $message_id = null,
        ?string $inline_message_id = null,
        ?string $caption = null,
        ParseMode|string|null $parse_mode = null,
        ?array $caption_entities = null,
        ?InlineKeyboardMarkup $reply_markup = null,
        ?bool $show_caption_above_media = null,
        ?string $business_connection_id = null,
    ): Message|bool|null {
        $parameters = compact(
            'chat_id',
            'message_id',
            'inline_message_id',
            'caption',
            'parse_mode',
            'caption_entities',
            'reply_markup',
            'show_caption_above_media',
            'business_connection_id',
        );
        $this->setChatMessageOrInlineMessageId($parameters);

        return $this->requestJson(__FUNCTION__, $parameters, Message::class);
    }

    /**
     * Use this method to edit animation, audio, document, photo, or video messages, or to add media to text messages.
     * If a message is part of a message album, then it can be edited only to an audio for audio albums, only to a document for document albums and to a photo or a video otherwise.
     * When an inline message is edited, a new file can't be uploaded;
     * use a previously uploaded file via its file_id or specify a URL.
     * On success, if the edited message is not an inline message, the edited {@see https://core.telegram.org/bots/api#message Message} is returned, otherwise True is returned.
     * @see https://core.telegram.org/bots/api#editmessagemedia
     * @param InputMedia $media A JSON-serialized object for a new media content of the message
     * @param int|string|null $chat_id Required if inline_message_id is not specified. Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int|null $message_id Required if inline_message_id is not specified. Identifier of the message to edit
     * @param string|null $inline_message_id Required if chat_id and message_id are not specified. Identifier of the inline message
     * @param InlineKeyboardMarkup|null $reply_markup A JSON-serialized object for a new {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}.
     * @param array $clientOpt Client options
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message to be edited was sent
     * @return Message|bool|null
     */
    public function editMessageMedia(
        InputMedia $media,
        int|string|null $chat_id = null,
        ?int $message_id = null,
        ?string $inline_message_id = null,
        ?InlineKeyboardMarkup $reply_markup = null,
        ?string $business_connection_id = null,
        array $clientOpt = [],
    ): Message|bool|null {
        $parameters = compact(
            'chat_id',
            'message_id',
            'inline_message_id',
            'media',
            'reply_markup',
            'business_connection_id',
        );
        $this->setChatMessageOrInlineMessageId($parameters);

        return $this->requestMultipart(__FUNCTION__, $parameters, Message::class, $clientOpt);
    }

    /**
     * Use this method to edit live location messages.
     * A location can be edited until its live_period expires or editing is explicitly disabled by a call to {@see https://core.telegram.org/bots/api#stopmessagelivelocation stopMessageLiveLocation}telegram.org/bots/api#message Message}LiveLocation.
     * On success, if the edited message is not an inline message, the edited Message is returned, otherwise True is returned.
     * @see https://core.telegram.org/bots/api#editmessagelivelocation
     * @param float $latitude Latitude of new location
     * @param float $longitude Longitude of new location
     * @param int|string|null $chat_id Required if inline_message_id is not specified. Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int|null $message_id Required if inline_message_id is not specified. Identifier of the message to edit
     * @param string|null $inline_message_id Required if chat_id and message_id are not specified. Identifier of the inline message
     * @param float|null $horizontal_accuracy The radius of uncertainty for the location, measured in meters; 0-1500
     * @param int|null $heading Direction in which the user is moving, in degrees. Must be between 1 and 360 if specified.
     * @param int|null $proximity_alert_radius The maximum distance for proximity alerts about approaching another chat member, in meters. Must be between 1 and 100000 if specified.
     * @param InlineKeyboardMarkup|null $reply_markup A JSON-serialized object for a new {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}.
     * @param int|null $live_period New period in seconds during which the location can be updated, starting from the message send date. If 0x7FFFFFFF is specified, then the location can be updated forever. Otherwise, the new value must not exceed the current live_period by more than a day, and the live location expiration date must remain within the next 90 days. If not specified, then live_period remains unchanged
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message to be edited was sent
     * @return Message|bool|null
     */
    public function editMessageLiveLocation(
        float $latitude,
        float $longitude,
        int|string|null $chat_id = null,
        ?int $message_id = null,
        ?string $inline_message_id = null,
        ?float $horizontal_accuracy = null,
        ?int $heading = null,
        ?int $proximity_alert_radius = null,
        ?InlineKeyboardMarkup $reply_markup = null,
        ?int $live_period = null,
        ?string $business_connection_id = null,
    ): Message|bool|null {
        $parameters = compact(
            'chat_id',
            'message_id',
            'inline_message_id',
            'latitude',
            'longitude',
            'horizontal_accuracy',
            'heading',
            'proximity_alert_radius',
            'reply_markup',
            'live_period',
            'business_connection_id',
        );

        $this->setChatMessageOrInlineMessageId($parameters);
        return $this->requestJson(__FUNCTION__, $parameters, Message::class);
    }

    /**
     * Use this method to edit only the reply markup of messages.
     * On success, if the edited message is not an inline message, the edited {@see https://core.telegram.org/bots/api#message Message} is returned, otherwise True is returned.
     * @see https://core.telegram.org/bots/api#editmessagereplymarkup
     * @param int|string|null $chat_id Required if inline_message_id is not specified. Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int|null $message_id Required if inline_message_id is not specified. Identifier of the message to edit
     * @param string|null $inline_message_id Required if chat_id and message_id are not specified. Identifier of the inline message
     * @param InlineKeyboardMarkup|null $reply_markup A JSON-serialized object for an {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}.
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message to be edited was sent
     * @return Message|bool|null
     */
    public function editMessageReplyMarkup(
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
     * Use this method to stop a poll which was sent by the bot.
     * On success, the stopped {@see https://core.telegram.org/bots/api#poll Poll} is returned.
     * @see https://core.telegram.org/bots/api#stoppoll
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int $message_id Identifier of the original message with the poll
     * @param InlineKeyboardMarkup|null $reply_markup A JSON-serialized object for a new message {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}.
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message to be edited was sent
     * @return Poll|null
     */
    public function stopPoll(
        int|string $chat_id,
        int $message_id,
        ?InlineKeyboardMarkup $reply_markup = null,
        ?string $business_connection_id = null,
    ): ?Poll {
        $parameters = compact(
            'chat_id',
            'message_id',
            'reply_markup',
            'business_connection_id',
        );

        return $this->requestJson(__FUNCTION__, $parameters, Poll::class);
    }

    /**
     * Use this method to delete a message, including service messages, with the following limitations:- A message can only be deleted if it was sent less than 48 hours ago.- Service messages about a supergroup, channel, or forum topic creation can't be deleted.- A dice message in a private chat can only be deleted if it was sent more than 24 hours ago.- Bots can delete outgoing messages in private chats, groups, and supergroups.- Bots can delete incoming messages in private chats.- Bots granted can_post_messages permissions can delete outgoing messages in channels.- If the bot is an administrator of a group, it can delete any message there.- If the bot has can_delete_messages permission in a supergroup or a channel, it can delete any message there.Returns True on success.
     * @see https://core.telegram.org/bots/api#deletemessage
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int $message_id Identifier of the message to delete
     * @return bool|null
     */
    public function deleteMessage(int|string $chat_id, int $message_id): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id', 'message_id'));
    }

    /**
     * Use this method to delete multiple messages simultaneously.
     * If some of the specified messages can't be found, they are skipped. Returns True on success.
     * @see https://core.telegram.org/bots/api#deletemessages
     * @param int|string $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int[] $message_ids Identifiers of 1-100 messages to delete. See {@see https://core.telegram.org/bots/api#deletemessage deleteMessage} for limitations on which messages can be deleted
     * @return bool|null
     */
    public function deleteMessages(int|string $chat_id, array $message_ids): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id', 'message_ids'));
    }
}
