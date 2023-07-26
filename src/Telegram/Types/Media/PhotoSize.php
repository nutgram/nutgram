<?php

namespace SergiX44\Nutgram\Telegram\Types\Media;

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Internal\Downloadable;

/**
 * This object represents one size of a photo or a {@see https://core.telegram.org/bots/api#document file} / {@see https://core.telegram.org/bots/api#sticker sticker} thumbnail.
 * @see https://core.telegram.org/bots/api#photosize
 */
class PhotoSize extends BaseType
{
    use Downloadable;

    /** Identifier for this file, which can be used to download or reuse the file */
    public string $file_id;

    /**
     * Unique identifier for this file, which is supposed to be the same over time and for different bots.
     * Can't be used to download or reuse the file.
     */
    public string $file_unique_id;

    /** Photo width */
    public int $width;

    /** Photo height */
    public int $height;

    /**
     * Optional.
     * File size in bytes
     */
    public ?int $file_size = null;
}
