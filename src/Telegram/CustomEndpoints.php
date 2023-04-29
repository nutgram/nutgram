<?php

namespace SergiX44\Nutgram\Telegram;

use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ForceReply;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardRemove;
use SergiX44\Nutgram\Telegram\Types\Message\Message;
use SergiX44\Nutgram\Telegram\Types\Message\MessageEntity;

/**
 * @mixin Client
 */
trait CustomEndpoints
{

    /**
     * Use this method to send text messages.
     * In case the text exceeds the maximum character limit, the text will be split into multiple messages.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message}s are returned.
     * @see https://core.telegram.org/bots/api#sendmessage
     * @param  string  $text Text of the message to be sent.
     * @param  array{
     *     parse_mode?:ParseMode|string,
     *     entities?:MessageEntity[],
     *     disable_web_page_preview?:bool,
     *     disable_notification?:bool,
     *     protect_content?:bool,
     *     reply_to_message_id?:int,
     *     allow_sending_without_reply?:bool,
     *     reply_markup?:InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply
     * }  $opt
     * @return Message[]|null
     */
    public function sendChunkedMessage(string $text, array $opt = []): ?array
    {
        $chat_id = $this->chatId();
        $required = compact('text', 'chat_id');
        $parameters = [...$required, ...$opt];

        //chunk text
        $chunks = $this->chunkText($text, Limits::TEXT_LENGTH);
        $totalChunks = count($chunks);

        //get reply_markup
        $reply_markup = $parameters['reply_markup'] ?? null;
        unset($parameters['reply_markup']);

        //send messages
        return array_map(function ($chunk, $index) use (&$parameters, $totalChunks, $reply_markup) {
            $parameters['reply_markup'] = $index === $totalChunks - 1 ? $reply_markup : null;
            $parameters['text'] = $chunk;
            return $this->requestJson('sendMessage', array_filter($parameters), Message::class);
        }, $chunks, array_keys($chunks));
    }

    /**
     * Use this method to send photos.
     * In case the caption exceeds the maximum character limit, the text will be split into multiple messages.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message}s are returned.
     * @see https://core.telegram.org/bots/api#sendphoto
     * @param  mixed  $photo Photo to send. Pass a file_id as String to send a photo that exists on the Telegram
     *     servers (recommended), pass an HTTP URL as a String for Telegram to get a photo from the Internet, or upload
     *     a new photo using multipart/form-data. The photo must be at most 10 MB in size. The photo's width and height
     *     must not exceed 10000 in total. Width and height ratio must be at most 20.
     *     {@see https://core.telegram.org/bots/api#sending-files More info on Sending Files »}
     * @param  array{
     *     caption?:string,
     *     parse_mode?:ParseMode|string,
     *     caption_entities?:MessageEntity[],
     *     disable_notification?:bool,
     *     protect_content?:bool,
     *     reply_to_message_id?:int,
     *     allow_sending_without_reply?:bool,
     *     reply_markup?:InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply
     * }  $opt
     * @param  array  $clientOpt
     * @return Message[]|null
     */
    public function sendChunkedPhoto(mixed $photo, array $opt = [], array $clientOpt = []): ?array
    {
        return $this->sendChunkedMedia(
            endpoint: 'sendPhoto',
            media: $photo,
            param: 'photo',
            opt: $opt,
            clientOpt: $clientOpt
        );
    }

    /**
     * Use this method to send audio files, if you want Telegram clients to display them in the music player.
     * In case the caption exceeds the maximum character limit, the text will be split into multiple messages.
     * Your audio must be in the .MP3 or .M4A format.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message}s are returned.
     * Bots can currently send audio files of up to 50 MB in size, this limit may be changed in the future.
     *
     * For sending voice messages, use the {@see https://core.telegram.org/bots/api#sendvoice sendVoice} method
     * instead.
     * @param  mixed  $audio Audio file to send. Pass a file_id as String to send an audio file that exists on the
     *     Telegram servers (recommended), pass an HTTP URL as a String for Telegram to get an audio file from the
     *     Internet, or upload a new one using multipart/form-data.
     *     {@see https://core.telegram.org/bots/api#sending-files More info on Sending Files »}
     * @param  array{
     *     caption?:string,
     *     parse_mode?:ParseMode|string,
     *     caption_entities?:MessageEntity[],
     *     duration?:int,
     *     performer?:string,
     *     title?:string,
     *     thumb?:InputFile|string,
     *     disable_notification?:bool,
     *     protect_content?:bool,
     *     reply_to_message_id?:int,
     *     allow_sending_without_reply?:bool,
     *     reply_markup?:InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply
     * }  $opt
     * @param  array  $clientOpt
     * @return Message[]|null
     */
    public function sendChunkedAudio(mixed $audio, array $opt = [], array $clientOpt = []): ?array
    {
        return $this->sendChunkedMedia(
            endpoint: 'sendAudio',
            media: $audio,
            param: 'audio',
            opt: $opt,
            clientOpt: $clientOpt
        );
    }

    /**
     * Use this method to send general files.
     * In case the caption exceeds the maximum character limit, the text will be split into multiple messages.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message}s are returned.
     * Bots can currently send files of any type of up to 50 MB in size, this limit may be changed in the future.
     * @see https://core.telegram.org/bots/api#senddocument
     * @param  mixed  $document File to send. Pass a file_id as String to send a file that exists on the Telegram
     *     servers (recommended), pass an HTTP URL as a String for Telegram to get a file from the Internet, or upload
     *     a new one using multipart/form-data.
     *     {@see https://core.telegram.org/bots/api#sending-files More info on Sending Files »}
     * @param  array{
     *     thumb?:InputFile|string,
     *     caption?:string,
     *     parse_mode?:ParseMode|string,
     *     caption_entities?:MessageEntity[],
     *     disable_content_type_detection?:bool,
     *     disable_notification?:bool,
     *     protect_content?:bool,
     *     reply_to_message_id?:int,
     *     allow_sending_without_reply?:bool,
     *     reply_markup?:InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply
     * }  $opt
     * @param  array  $clientOpt
     * @return Message[]|null
     */
    public function sendChunkedDocument(mixed $document, array $opt = [], array $clientOpt = []): ?array
    {
        return $this->sendChunkedMedia(
            endpoint: 'sendDocument',
            media: $document,
            param: 'document',
            opt: $opt,
            clientOpt: $clientOpt
        );
    }

    /**
     * Use this method to send video files, Telegram clients support mp4 videos
     * (other formats may be sent as {@see https://core.telegram.org/bots/api#document Document}).
     * In case the caption exceeds the maximum character limit, the text will be split into multiple messages.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message}s are returned.
     * Bots can currently send video files of up to 50 MB in size, this limit may be changed in the future.
     * @see https://core.telegram.org/bots/api#sendvideo
     * @param  mixed  $video Video to send. Pass a file_id as String to send a video that exists on the Telegram
     *     servers (recommended), pass an HTTP URL as a String for Telegram to get a video from the Internet, or upload
     *     a new video using multipart/form-data.
     *     {@see https://core.telegram.org/bots/api#sending-files More info on Sending Files »}
     * @param  array{
     *     duration?:int,
     *     width?:int,
     *     height?:int,
     *     thumb?:InputFile|string,
     *     caption?:string,
     *     parse_mode?:ParseMode|string,
     *     caption_entities?:MessageEntity[],
     *     supports_streaming?:bool,
     *     disable_notification?:bool,
     *     protect_content?:bool,
     *     reply_to_message_id?:int,
     *     allow_sending_without_reply?:bool,
     *     reply_markup?:InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply
     * }  $opt
     * @param  array  $clientOpt
     * @return Message[]|null
     */
    public function sendChunkedVideo(mixed $video, array $opt = [], array $clientOpt = []): ?array
    {
        return $this->sendChunkedMedia(
            endpoint: 'sendVideo',
            media: $video,
            param: 'video',
            opt: $opt,
            clientOpt: $clientOpt
        );
    }

    /**
     * Use this method to send animation files (GIF or H.264/MPEG-4 AVC video without sound).
     * In case the caption exceeds the maximum character limit, the text will be split into multiple messages.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message}s are returned.
     * Bots can currently send animation files of up to 50 MB in size, this limit may be changed in the future.
     * @see https://core.telegram.org/bots/api#sendanimation
     * @param  mixed  $animation Animation to send. Pass a file_id as String to send an animation that exists on the
     *     Telegram servers (recommended), pass an HTTP URL as a String for Telegram to get an animation from the
     *     Internet, or upload a new animation using multipart/form-data.
     *     {@see https://core.telegram.org/bots/api#sending-files More info on Sending Files »}
     * @param  array{
     *     duration?:int,
     *     width?:int,
     *     height?:int,
     *     thumb?:InputFile|string,
     *     caption?:string,
     *     parse_mode?:ParseMode|string,
     *     caption_entities?:MessageEntity[],
     *     disable_notification?:bool,
     *     protect_content?:bool,
     *     reply_to_message_id?:int,
     *     allow_sending_without_reply?:bool,
     *     reply_markup?:InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply
     * }  $opt
     * @param  array  $clientOpt
     * @return Message[]|null
     */
    public function sendChunkedAnimation(mixed $animation, array $opt = [], array $clientOpt = []): ?array
    {
        return $this->sendChunkedMedia(
            endpoint: 'sendAnimation',
            media: $animation,
            param: 'animation',
            opt: $opt,
            clientOpt: $clientOpt
        );
    }

    /**
     * Use this method to send audio files, if you want Telegram clients to display the file as a playable voice
     * message. For this to work, your audio must be in an .OGG file encoded with OPUS
     * (other formats may be sent as {@see https://core.telegram.org/bots/api#audio Audio}
     * or {@see https://core.telegram.org/bots/api#document Document}).
     * In case the caption exceeds the maximum character limit, the text will be split into multiple messages.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message}s are returned.
     * Bots can currently send voice messages of up to 50 MB in size, this limit may be changed in the future.
     * @see https://core.telegram.org/bots/api#sendvoice
     * @param  mixed  $voice Audio file to send. Pass a file_id as String to send a file that exists on the Telegram
     *     servers (recommended), pass an HTTP URL as a String for Telegram to get a file from the Internet, or upload
     *     a new one using multipart/form-data.
     *     {@see https://core.telegram.org/bots/api#sending-files More info on Sending Files »}
     * @param  array{
     *     caption?:string,
     *     parse_mode?:ParseMode|string,
     *     caption_entities?:MessageEntity[],
     *     duration?:int,
     *     disable_notification?:bool,
     *     protect_content?:bool,
     *     reply_to_message_id?:int,
     *     allow_sending_without_reply?:bool,
     *     reply_markup?:InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply
     * }  $opt
     * @param  array  $clientOpt
     * @return Message[]|null
     */
    public function sendChunkedVoice(mixed $voice, array $opt = [], array $clientOpt = []): ?array
    {
        return $this->sendChunkedMedia(
            endpoint: 'sendVoice',
            media: $voice,
            param: 'voice',
            opt: $opt,
            clientOpt: $clientOpt
        );
    }

    protected function sendChunkedMedia(
        string $endpoint,
        mixed $media,
        string $param,
        array $opt = [],
        $clientOpt = []
    ): ?array {
        $caption = $opt['caption'] ?? null;

        if ($caption === null) {
            return [$this->sendAttachment($endpoint, $param, $media, array_filter($opt), $clientOpt)];
        }

        //chunk caption
        $chunks = $this->chunkText($caption, Limits::CAPTION_LENGTH);
        $totalChunks = count($chunks);

        //get reply_markup
        $reply_markup = $opt['reply_markup'] ?? null;
        unset($opt['reply_markup']);

        //send messages
        return array_map(function ($chunk, $index) use (
            $param,
            $clientOpt,
            $media,
            &$opt,
            $totalChunks,
            $reply_markup,
            $endpoint
        ) {
            $opt['reply_markup'] = $index === $totalChunks - 1 ? $reply_markup : null;
            $opt['caption'] = $chunk;

            if ($index === 0) {
                return $this->sendAttachment($endpoint, $param, $media, array_filter($opt), $clientOpt);
            }

            return $this->requestJson('sendMessage', array_filter($opt), Message::class);
        }, $chunks, array_keys($chunks));
    }
}
