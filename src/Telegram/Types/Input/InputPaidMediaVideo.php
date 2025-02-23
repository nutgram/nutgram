<?php

namespace SergiX44\Nutgram\Telegram\Types\Input;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputPaidMediaType;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * The paid media to send is a video.
 * @see https://core.telegram.org/bots/api#inputpaidmediavideo
 */
#[SkipConstructor]
class InputPaidMediaVideo extends InputPaidMedia implements JsonSerializable
{
    /**
     * Type of the media, must be video
     */
    #[EnumOrScalar]
    public InputPaidMediaType|string $type = InputPaidMediaType::VIDEO;

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
    public InputFile|string|null $thumbnail = null;

    /**
     * Optional.
     * Cover for the video in the message.
     * Pass a file_id to send a file that exists on the Telegram servers (recommended),
     * pass an HTTP URL for Telegram to get a file from the Internet,
     * or pass “attach://<file_attach_name>” to upload a new one using multipart/form-data under <file_attach_name> name.
     * {@see https://core.telegram.org/bots/api#sending-files More information on Sending Files »}
     */
    public InputFile|string|null $cover = null;

    /**
     * Optional.
     * Start timestamp for the video in the message
     */
    public ?int $start_timestamp = null;

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

    public function __construct(
        InputFile|string $media,
        InputFile|string|null $thumbnail = null,
        ?int $width = null,
        ?int $height = null,
        ?int $duration = null,
        ?bool $supports_streaming = null,
        InputFile|string|null $cover = null,
        ?int $start_timestamp = null,
    ) {
        parent::__construct();
        $this->media = $media;
        $this->thumbnail = $thumbnail;
        $this->width = $width;
        $this->height = $height;
        $this->duration = $duration;
        $this->supports_streaming = $supports_streaming;
        $this->cover = $cover;
        $this->start_timestamp = $start_timestamp;
    }

    public static function make(
        InputFile|string $media,
        InputFile|string|null $thumbnail = null,
        ?int $width = null,
        ?int $height = null,
        ?int $duration = null,
        ?bool $supports_streaming = null,
        InputFile|string|null $cover = null,
        ?int $start_timestamp = null,
    ): self {
        return new self(
            media: $media,
            thumbnail: $thumbnail,
            width: $width,
            height: $height,
            duration: $duration,
            supports_streaming: $supports_streaming,
            cover: $cover,
            start_timestamp: $start_timestamp,
        );
    }

    public function jsonSerialize(): array
    {
        return array_filter_null([
            'type' => $this->type,
            'media' => $this->media,
            'thumbnail' => $this->thumbnail,
            'cover' => $this->cover,
            'start_timestamp' => $this->start_timestamp,
            'width' => $this->width,
            'height' => $this->height,
            'duration' => $this->duration,
            'supports_streaming' => $this->supports_streaming,
        ]);
    }
}
