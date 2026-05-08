<?php

namespace SergiX44\Nutgram\Telegram\Types\Input;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputPaidMediaType;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * The paid media to send is a live photo.
 * @see https://core.telegram.org/bots/api#inputpaidmedialivephoto
 */
#[SkipConstructor]
class InputPaidMediaLivePhoto extends InputPaidMedia implements JsonSerializable
{
    /**
     * Type of the media, must be live_photo
     */
    #[EnumOrScalar]
    public InputPaidMediaType|string $type = InputPaidMediaType::LIVE_PHOTO;

    /**
     * The static photo to send.
     * Pass a file_id to send a file that exists on the Telegram servers (recommended),
     * pass an HTTP URL for Telegram to get a file from the Internet,
     * or pass “attach://<file_attach_name>” to upload a new one using multipart/form-data under <file_attach_name> name.
     * {@see https://core.telegram.org/bots/api#sending-files More information on Sending Files »}
     */
    public InputFile|string $photo;


    public function __construct(
        InputFile|string $media,
        InputFile|string $photo,
    ) {
        parent::__construct();
        $this->media = $media;
        $this->photo = $photo;
    }

    public static function make(
        InputFile|string $media,
        InputFile|string $photo,
    ): self {
        return new self(
            media: $media,
            photo: $photo,
        );
    }


    public function jsonSerialize(): array
    {
        return array_filter_null([
            'type' => $this->type,
            'media' => $this->media,
            'photo' => $this->photo,
        ]);
    }
}
