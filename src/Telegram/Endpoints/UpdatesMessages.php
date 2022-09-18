<?php


namespace SergiX44\Nutgram\Telegram\Endpoints;

use SergiX44\Nutgram\Telegram\Client;
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
     * On success, if the edited message is not an inline message,
     * the edited {@see https://core.telegram.org/bots/api#message Message} is returned, otherwise True is returned.
     * @see https://core.telegram.org/bots/api#editmessagetext
     * @param  string  $text New text of the message, 1-4096 characters after entities parsing
     * @param  array{
     *     chat_id?:int|string,
     *     message_id?:int,
     *     inline_message_id?:string,
     *     parse_mode?:string,
     *     entities?:MessageEntity[],
     *     disable_web_page_preview?:bool,
     *     reply_markup?:InlineKeyboardMarkup
     * }  $opt
     * @return Message|bool|null
     */
    public function editMessageText(string $text, array $opt = []): Message|bool|null
    {
        $target = $this->targetChatMessageOrInlineMessageId($opt);
        $required = compact('text');
        return $this->requestJson(__FUNCTION__, array_merge($target, $required, $opt), Message::class);
    }

    /**
     * Use this method to edit captions of messages.
     * On success, if the edited message is not an inline message,
     * the edited {@see https://core.telegram.org/bots/api#message Message} is returned, otherwise True is returned.
     * @see https://core.telegram.org/bots/api#editmessagecaption
     * @param  array{
     *     chat_id?:int|string,
     *     message_id?:int,
     *     inline_message_id?:string,
     *     caption?:string,
     *     parse_mode?:string,
     *     caption_entities?:MessageEntity[],
     *     reply_markup?:InlineKeyboardMarkup
     * }  $opt
     * @return Message|bool|null
     */
    public function editMessageCaption(array $opt = []): Message|bool|null
    {
        $target = $this->targetChatMessageOrInlineMessageId($opt);
        return $this->requestJson(__FUNCTION__, array_merge($target, $opt), Message::class);
    }

    /**
     * Use this method to edit animation, audio, document, photo, or video messages.
     * If a message is part of a message album, then it can be edited only to an audio for audio albums,
     * only to a document for document albums and to a photo or a video otherwise.
     * When an inline message is edited, a new file can't be uploaded.
     * Use a previously uploaded file via its file_id or specify a URL.
     * On success, if the edited message was sent by the bot,
     * the edited {@see https://core.telegram.org/bots/api#message Message} is returned, otherwise True is returned.
     * @see https://core.telegram.org/bots/api#editmessagemedia
     * @param  array  $mediaArray An object for a new media content of the message
     * @param  array{
     *     chat_id?:int|string,
     *     message_id?:int,
     *     inline_message_id?:string,
     *     reply_markup?:InlineKeyboardMarkup
     * }  $opt
     * @param  array  $clientOpt
     * @return Message|bool|null
     * @throws \JsonException
     */
    public function editMessageMedia(array $mediaArray, array $opt = [], array $clientOpt = []): Message|bool|null
    {
        $target = $this->targetChatMessageOrInlineMessageId($opt);
        $media = json_encode($mediaArray, JSON_THROW_ON_ERROR);
        $required = compact('media');
        return $this->requestMultipart(__FUNCTION__, array_merge($target, $required, $opt), Message::class, $clientOpt);
    }

    /**
     * Use this method to edit only the reply markup of messages.
     * On success, if the edited message is not an inline message,
     * the edited {@see https://core.telegram.org/bots/api#message Message} is returned, otherwise True is returned.
     * @see https://core.telegram.org/bots/api#editmessagereplymarkup
     * @param  array{
     *     chat_id?:int|string,
     *     message_id?:int,
     *     inline_message_id?:string,
     *     reply_markup?:InlineKeyboardMarkup
     * }  $opt
     * @return Message|bool|null
     */
    public function editMessageReplyMarkup(array $opt = []): Message|bool|null
    {
        $target = $this->targetChatMessageOrInlineMessageId($opt);
        return $this->requestJson(__FUNCTION__, array_merge($target, $opt), Message::class);
    }

    /**
     * Use this method to stop a poll which was sent by the bot.
     * On success, the stopped {@see https://core.telegram.org/bots/api#poll Poll} with the final results is returned.
     * @see https://core.telegram.org/bots/api#stoppoll
     * @param  string|int  $chat_id Unique identifier for the target chat or username of the target channel (in the
     *     format [at]channelusername)
     * @param  int  $message_id Identifier of the original message with the poll
     * @param  array{
     *     reply_markup?:InlineKeyboardMarkup
     * }  $opt
     * @return Poll|null
     */
    public function stopPoll(string|int $chat_id, int $message_id, array $opt = []): ?Poll
    {
        $required = compact('chat_id', 'message_id');
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt), Poll::class);
    }

    /**
     * Use this method to delete a message, including service messages, with the following limitations:
     * - A message can only be deleted if it was sent less than 48 hours ago.
     * - A dice message in a private chat can only be deleted if it was sent more than 24 hours ago.
     * - Bots can delete outgoing messages in private chats, groups, and supergroups.
     * - Bots can delete incoming messages in private chats.
     * - Bots granted can_post_messages permissions can delete outgoing messages in channels.
     * - If the bot is an administrator of a group, it can delete any message there.
     * - If the bot has can_delete_messages permission in a supergroup or a channel, it can delete any message there.
     *
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#deletemessage
     * @param  string|int  $chat_id Unique identifier for the target chat or username of the target channel (in the
     *     format [at]channelusername)
     * @param  int  $message_id Identifier of the message to delete
     * @return bool|null
     */
    public function deleteMessage(string|int $chat_id, int $message_id): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id', 'message_id'));
    }
}
