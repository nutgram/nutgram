<?php

namespace SergiX44\Nutgram\Telegram\Types\Media;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Internal\Downloadable;

/**
 * This object represents a live photo.
 * @see https://core.telegram.org/bots/api#livephoto
 */
class LivePhoto extends BaseType
{
    use Downloadable;

    /**
     * Optional. Available sizes of the corresponding static photo
     * @var PhotoSize[]|null
     */
    #[ArrayType(PhotoSize::class)]
    public ?array $photo = null;

    /**
     * Identifier for the video file which can be used to download or reuse the file
     */
    public string $file_id;

    /**
     * Unique identifier for this file, which is supposed to be the same over time and for different bots.
     * Can't be used to download or reuse the file.
     */
    public string $file_unique_id;

    /**
     * Video width as defined by the sender
     */
    public int $width;

    /**
     * Video height as defined by the sender
     */
    public int $height;

    /**
     * Duration of the video in seconds as defined by the sender
     */
    public int $duration;

    /**
     * Optional. MIME type of the file as defined by the sender
     */
    public ?string $mime_type = null;

    /**
     * Optional. File size in bytes.
     * It can be bigger than 2^31 and some programming languages may have difficulty/silent defects in interpreting it.
     * But it has at most 52 significant bits, so a signed 64-bit integer or double-precision float type are safe for storing this value.
     */
    public ?int $file_size = null;
}
