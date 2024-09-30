<?php

namespace SergiX44\Nutgram\Telegram\Endpoints;

use SergiX44\Nutgram\Telegram\Client;
use SergiX44\Nutgram\Telegram\Limits;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ForceReply;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardRemove;
use SergiX44\Nutgram\Telegram\Types\Message\Message;
use SergiX44\Nutgram\Telegram\Types\Message\MessageEntity;
use function SergiX44\Nutgram\Support\array_filter_null;

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
     * @param string $text Text of the message to be sent, 1-4096 characters after entities parsing
     * @param int|string|null $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param ParseMode|string|null $parse_mode Mode for parsing entities in the message text. See {@see https://core.telegram.org/bots/api#formatting-options formatting options} for more details.
     * @param MessageEntity[]|null $entities A JSON-serialized list of special entities that appear in message text, which can be specified instead of parse_mode
     * @param bool|null $disable_web_page_preview Disables link previews for links in this message
     * @param bool|null $disable_notification Sends the message {@see https://telegram.org/blog/channels-2-0#silent-messages silently}. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param int|null $reply_to_message_id If the message is a reply, ID of the original message
     * @param bool|null $allow_sending_without_reply Pass True if the message should be sent even if the specified replied-to message is not found
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}, {@see https://core.telegram.org/bots/features#keyboards custom reply keyboard}, instructions to remove reply keyboard or to force a reply from the user.
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @return Message[]|null
     */
    public function sendChunkedMessage(
        string $text,
        int|string|null $chat_id = null,
        ?int $message_thread_id = null,
        ParseMode|string|null $parse_mode = null,
        ?array $entities = null,
        ?bool $disable_web_page_preview = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
        ?int $reply_to_message_id = null,
        ?bool $allow_sending_without_reply = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
        ?string $business_connection_id = null,
        ?string $message_effect_id = null,
    ): ?array {
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
            'disable_notification',
            'protect_content',
            'reply_to_message_id',
            'allow_sending_without_reply',
            'reply_markup',
            'business_connection_id',
            'message_effect_id',
        );
        unset($parameters['text']);

        // chunk text
        $chunks = $this->chunkText($text, Limits::TEXT_LENGTH);
        $totalChunks = count($chunks);

        // get reply_markup
        $replyMarkup = $parameters['reply_markup'] ?? null;
        unset($parameters['reply_markup']);

        //send messages
        return array_map(fn ($chunk, $index) => $this->sendMessage(
            text: $chunk,
            chat_id: $parameters['chat_id'],
            message_thread_id: $parameters['message_thread_id'],
            parse_mode: $parameters['parse_mode'],
            entities: $parameters['entities'],
            disable_web_page_preview: $parameters['disable_web_page_preview'],
            disable_notification: $parameters['disable_notification'],
            protect_content: $parameters['protect_content'],
            reply_to_message_id: $parameters['reply_to_message_id'],
            allow_sending_without_reply: $parameters['allow_sending_without_reply'],
            reply_markup: $index === $totalChunks - 1 ? $replyMarkup : null,
        ), $chunks, array_keys($chunks));
    }

    /**
     * Use this method to send photos.
     * In case the caption exceeds the maximum character limit, the text will be split into multiple messages.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message}s are returned.
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
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}, {@see https://core.telegram.org/bots/features#keyboards custom reply keyboard}, instructions to remove reply keyboard or to force a reply from the user.
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param array $clientOpt Client options
     * @return Message[]|null
     */
    public function sendChunkedPhoto(
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
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
        ?string $business_connection_id = null,
        ?string $message_effect_id = null,
        array $clientOpt = [],
    ): ?array {
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
            'reply_markup',
            'business_connection_id',
            'message_effect_id',
        );
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
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}, {@see https://core.telegram.org/bots/features#keyboards custom reply keyboard}, instructions to remove reply keyboard or to force a reply from the user.
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param array $clientOpt Client options
     * @return Message[]|null
     */
    public function sendChunkedAudio(
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
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
        ?string $business_connection_id = null,
        ?string $message_effect_id = null,
        array $clientOpt = [],
    ): ?array {
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
            'reply_markup',
            'business_connection_id',
            'message_effect_id',
        );

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
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}, {@see https://core.telegram.org/bots/features#keyboards custom reply keyboard}, instructions to remove reply keyboard or to force a reply from the user.
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param array $clientOpt Client options
     * @return Message[]|null
     */
    public function sendChunkedDocument(
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
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
        ?string $business_connection_id = null,
        ?string $message_effect_id = null,
        array $clientOpt = [],
    ): ?array {
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
            'reply_markup',
            'business_connection_id',
            'message_effect_id',
        );

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
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}, {@see https://core.telegram.org/bots/features#keyboards custom reply keyboard}, instructions to remove reply keyboard or to force a reply from the user.
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param array $clientOpt Client options
     * @return Message[]|null
     */
    public function sendChunkedVideo(
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
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
        ?string $business_connection_id = null,
        ?string $message_effect_id = null,
        array $clientOpt = [],
    ): ?array {
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
            'reply_markup',
            'business_connection_id',
            'message_effect_id',
        );

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
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}, {@see https://core.telegram.org/bots/features#keyboards custom reply keyboard}, instructions to remove reply keyboard or to force a reply from the user.
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param array $clientOpt Client options
     * @return Message[]|null
     */
    public function sendChunkedAnimation(
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
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
        ?string $business_connection_id = null,
        ?string $message_effect_id = null,
        array $clientOpt = [],
    ): ?array {
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
            'reply_markup',
            'business_connection_id',
            'message_effect_id',
        );

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
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}, {@see https://core.telegram.org/bots/features#keyboards custom reply keyboard}, instructions to remove reply keyboard or to force a reply from the user.
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param array $clientOpt Client options
     * @return Message[]|null
     */
    public function sendChunkedVoice(
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
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
        ?string $business_connection_id = null,
        ?string $message_effect_id = null,
        array $clientOpt = [],
    ): ?array {
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
            'reply_markup',
            'business_connection_id',
            'message_effect_id',
        );

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
        InputFile|string $media,
        string $param,
        array $opt = [],
        $clientOpt = []
    ): ?array {
        $caption = $opt['caption'] ?? null;

        if ($caption === null) {
            return [
                $this->sendAttachment(
                    endpoint: $endpoint,
                    param: $param,
                    value: $media,
                    opt: array_filter_null($opt),
                    clientOpt: $clientOpt
                ),
            ];
        }

        $opt = array_filter_null($opt);

        //chunk caption
        $chunks = $this->chunkText($caption, Limits::CAPTION_LENGTH);
        $totalChunks = count($chunks);

        //get reply_markup
        $replyMarkup = $opt['reply_markup'] ?? null;

        unset($opt['reply_markup'], $opt['caption']);

        //send messages
        return array_map(function ($chunk, $index) use (
            $param,
            $clientOpt,
            $media,
            &$opt,
            $totalChunks,
            $replyMarkup,
            $endpoint
        ) {
            if ($index === $totalChunks - 1 && $replyMarkup !== null) {
                $opt['reply_markup'] = $replyMarkup;
            }

            if ($index === 0) {
                $opt['caption'] = $chunk;
                return $this->sendAttachment(
                    endpoint: $endpoint,
                    param: $param,
                    value: $media,
                    opt: $opt,
                    clientOpt: $clientOpt
                );
            }

            $parameters = [
                'text' => $chunk,
                ...$opt,
            ];

            return $this->sendMessage(...$parameters);
        }, $chunks, array_keys($chunks));
    }
}
