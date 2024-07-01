<?php

namespace SergiX44\Nutgram\Telegram\Types\Input;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputPaidMediaType;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;
use SergiX44\Nutgram\Telegram\Types\Message\MessageEntity;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * The paid media to send is a video.
 * @see https://core.telegram.org/bots/api#inputpaidmediavideo
 */
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
    ) {
        parent::__construct();
        $this->media = $media;
        $this->thumbnail = $thumbnail;
        $this->width = $width;
        $this->height = $height;
        $this->duration = $duration;
        $this->supports_streaming = $supports_streaming;
    }

    public static function make(
        InputFile|string $media,
        InputFile|string|null $thumbnail = null,
        ?int $width = null,
        ?int $height = null,
        ?int $duration = null,
        ?bool $supports_streaming = null,
    ): self {
        return new self(
            media: $media,
            thumbnail: $thumbnail,
            width: $width,
            height: $height,
            duration: $duration,
            supports_streaming: $supports_streaming,
        );
    }

    public function jsonSerialize(): array
    {
        return array_filter_null([
            'type' => $this->type,
            'media' => $this->media,
            'width' => $this->width,
            'height' => $this->height,
            'duration' => $this->duration,
            'supports_streaming' => $this->supports_streaming,
        ]);
    }
}
