<?php

namespace SergiX44\Nutgram\Telegram\Types\Input;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputMediaType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;
use SergiX44\Nutgram\Telegram\Types\Internal\Uploadable;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * Represents a sticker file to be sent.
 * @see https://core.telegram.org/bots/api#inputmediasticker
 */
#[SkipConstructor]
class InputMediaSticker extends BaseType implements InputPollOptionMedia, Uploadable, JsonSerializable
{
    /**
     * Type of the result, must be sticker
     */
    #[EnumOrScalar]
    public InputMediaType|string $type = InputMediaType::STICKER;

    /**
     * File to send. Pass a file_id to send a file that exists on the Telegram servers (recommended),
     * pass an HTTP URL for Telegram to get a .WEBP sticker from the Internet,
     * or pass “attach://<file_attach_name>” to upload a new .WEBP, .TGS, or .WEBM sticker
     * using multipart/form-data under <file_attach_name> name.
     * More information on Sending Files »
     */
    public InputFile|string $media;

    /**
     * Optional. Emoji associated with the sticker; only for just uploaded stickers
     */
    public ?string $emoji = null;

    public function __construct(InputFile|string $media, ?string $emoji = null)
    {
        parent::__construct();
        $this->media = $media;
        $this->emoji = $emoji;
    }

    public static function make(InputFile|string $media, ?string $emoji = null): self
    {
        return new self(
            media: $media,
            emoji: $emoji,
        );
    }

    public function jsonSerialize(): array
    {
        return array_filter_null([
            'type' => $this->type,
            'media' => $this->media,
            'emoji' => $this->emoji,
        ]);
    }

    public function isLocal(): bool
    {
        return $this->media instanceof InputFile;
    }

    public function getResource()
    {
        return $this->media->getResource();
    }

    public function getFilename(): string
    {
        return $this->media->getFilename();
    }
}
