<?php

namespace SergiX44\Nutgram\Telegram\Types\Input;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Properties\InputMediaType;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Message\MessageEntity;

/**
 * Represents a video to be sent.
 * @see https://core.telegram.org/bots/api#inputmediavideo
 */
class InputMediaVideo extends InputMedia
{
    /** Type of the result, must be video */
    public InputMediaType $type = InputMediaType::VIDEO;

    /**
     * File to send.
     * Pass a file_id to send a file that exists on the Telegram servers (recommended), pass an HTTP URL for Telegram to get a file from the Internet, or pass “attach://<file_attach_name>” to upload a new one using multipart/form-data under <file_attach_name> name.
     * {@see https://core.telegram.org/bots/api#sending-files More information on Sending Files »}
     */
    public mixed $media;

    /**
     * Optional.
     * Thumbnail of the file sent;
     * can be ignored if thumbnail generation for the file is supported server-side.
     * The thumbnail should be in JPEG format and less than 200 kB in size.
     * A thumbnail's width and height should not exceed 320.
     * Ignored if the file is not uploaded using multipart/form-data.
     * Thumbnails can't be reused and can be only uploaded as a new file, so you can pass “attach://<file_attach_name>” if the thumbnail was uploaded using multipart/form-data under <file_attach_name>.
     * {@see https://core.telegram.org/bots/api#sending-files More information on Sending Files »}
     */
    public mixed $thumbnail = null;

    /**
     * Optional.
     * Caption of the video to be sent, 0-1024 characters after entities parsing
     */
    public ?string $caption = null;

    /**
     * Optional.
     * Mode for parsing entities in the video caption.
     * See {@see https://core.telegram.org/bots/api#formatting-options formatting options} for more details.
     */
    public ?ParseMode $parse_mode = null;

    /**
     * Optional.
     * List of special entities that appear in the caption, which can be specified instead of parse_mode
     * @var MessageEntity[] $caption_entities
     */
    #[ArrayType(MessageEntity::class)]
    public ?array $caption_entities = null;

    /**
     * Optional.
     * Video width
     */
    public ?int $width = null;

    /**
     * Optional.
     * Video height
     */
    public ?int $height = null;

    /**
     * Optional.
     * Video duration in seconds
     */
    public ?int $duration = null;

    /**
     * Optional.
     * Pass True if the uploaded video is suitable for streaming
     */
    public ?bool $supports_streaming = null;

    /**
     * Optional.
     * Pass True if the video needs to be covered with a spoiler animation
     */
    public ?bool $has_spoiler = null;
}
