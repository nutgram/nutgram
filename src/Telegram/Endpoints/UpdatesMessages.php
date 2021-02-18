<?php


namespace SergiX44\Nutgram\Telegram\Endpoints;

use SergiX44\Nutgram\Telegram\Client;
use SergiX44\Nutgram\Telegram\Types\Message;
use SergiX44\Nutgram\Telegram\Types\Poll;

/**
 * Trait UpdatesMessages
 * @package SergiX44\Nutgram\Telegram
 * @mixin Client
 */
trait UpdatesMessages
{
    /**
     * @param  string  $text
     * @param  array|null  $opt
     * @return Message|bool
     */
    public function editMessageText(string $text, ?array $opt = []): Message|bool
    {
        $chat_id = $this->chatId();
        $message_id = $this->messageId();
        $required = compact('text', 'chat_id', 'message_id');
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt), Message::class);
    }

    /**
     * @param  array|null  $opt
     * @return Message|bool
     */
    public function editMessageCaption(?array $opt = []): Message|bool
    {
        $chat_id = $this->chatId();
        $message_id = $this->messageId();
        $required = compact('chat_id', 'message_id');
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt), Message::class);
    }

    /**
     * @param  array  $media
     * @param  array|null  $opt
     * @return Message|bool
     */
    public function editMessageMedia(array $media, ?array $opt = []): Message|bool
    {
        $chat_id = $this->chatId();
        $message_id = $this->messageId();
        $media = json_encode($media);
        $required = compact('media', 'chat_id', 'message_id');
        return $this->requestMultipart(__FUNCTION__, array_merge($required, $opt), Message::class);
    }

    /**
     * @param  array|null  $opt
     * @return Message|bool
     */
    public function editMessageReplyMarkup(?array $opt = []): Message|bool
    {
        $chat_id = $this->chatId();
        $message_id = $this->messageId();
        $required = compact('chat_id', 'message_id');
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt), Message::class);
    }

    /**
     * @param  string|int  $chat_id
     * @param  int  $message_id
     * @param  array|null  $opt
     * @return Poll
     */
    public function stopPoll(string|int $chat_id, int $message_id, ?array $opt = []): Poll
    {
        $required = compact('chat_id', 'message_id');
        return $this->requestJson(__FUNCTION__, array_merge($required, $opt), Poll::class);
    }

    /**
     * @param  string|int  $chat_id
     * @param  int  $message_id
     * @return bool
     */
    public function deleteMessage(string|int $chat_id, int $message_id): bool
    {
        return $this->requestJson(__FUNCTION__, compact('chat_id', 'message_id'));
    }
}