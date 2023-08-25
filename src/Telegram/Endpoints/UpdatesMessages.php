<?php

namespace SergiX44\Nutgram\Telegram\Endpoints;

use SergiX44\Nutgram\Telegram\Client;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Input\InputMedia;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
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
     * @param InlineKeyboardMarkup|null $reply_markup A JSON-serialized object for an {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}.
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
        ?InlineKeyboardMarkup $reply_markup = null,
    ): Message|bool|null {
        $parameters = compact(
            'chat_id',
            'message_id',
            'inline_message_id',
            'text',
            'parse_mode',
            'entities',
            'disable_web_page_preview',
            'reply_markup'
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
    ): Message|bool|null {
        $parameters = compact(
            'chat_id',
            'message_id',
            'inline_message_id',
            'caption',
            'parse_mode',
            'caption_entities',
            'reply_markup'
        );
        $this->setChatMessageOrInlineMessageId($parameters);

        return $this->requestJson(__FUNCTION__, $parameters, Message::class);
    }

    /**
     * Use this method to edit animation, audio, document, photo, or video messages.
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
     * @return Message|bool|null
     */
    public function editMessageMedia(
        InputMedia $media,
        int|string|null $chat_id = null,
        ?int $message_id = null,
        ?string $inline_message_id = null,
        ?InlineKeyboardMarkup $reply_markup = null,
        array $clientOpt = [],
    ): Message|bool|null {
        $parameters = compact(
            'chat_id',
            'message_id',
            'inline_message_id',
            'media',
            'reply_markup',
            'clientOpt'
        );
        $this->setChatMessageOrInlineMessageId($parameters);

        return $this->requestMultipart(__FUNCTION__, $parameters, Message::class, $clientOpt);
    }

    /**
     * Use this method to edit only the reply markup of messages.
     * On success, if the edited message is not an inline message, the edited {@see https://core.telegram.org/bots/api#message Message} is returned, otherwise True is returned.
     * @see https://core.telegram.org/bots/api#editmessagereplymarkup
     * @param int|string|null $chat_id Required if inline_message_id is not specified. Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int|null $message_id Required if inline_message_id is not specified. Identifier of the message to edit
     * @param string|null $inline_message_id Required if chat_id and message_id are not specified. Identifier of the inline message
     * @param InlineKeyboardMarkup|null $reply_markup A JSON-serialized object for an {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}.
     * @return Message|bool|null
     */
    public function editMessageReplyMarkup(
        int|string|null $chat_id = null,
        ?int $message_id = null,
        ?string $inline_message_id = null,
        ?InlineKeyboardMarkup $reply_markup = null,
    ): Message|bool|null {
        $parameters = compact(
            'chat_id',
            'message_id',
            'inline_message_id',
            'reply_markup'
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
     * @return Poll|null
     */
    public function stopPoll(int|string $chat_id, int $message_id, ?InlineKeyboardMarkup $reply_markup = null): ?Poll
    {
        $parameters = compact('chat_id', 'message_id', 'reply_markup');
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
}
