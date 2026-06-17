<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Input;

use SergiX44\Hydrator\Annotation\OverrideConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputPaidMediaType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;
use SergiX44\Nutgram\Telegram\Types\Internal\Uploadables;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * The paid media to send is a photo.
 * @see https://core.telegram.org/bots/api#inputpaidmediaphoto
 */
#[OverrideConstructor('bindToInstance')]
class InputPaidMediaPhoto extends BaseType implements InputPaidMedia, Uploadables
{
    /**
     * Type of the media, must be photo
     */
    #[EnumOrScalar]
    public InputPaidMediaType|string $type = InputPaidMediaType::PHOTO;

    /**
     * File to send.
     * Pass a file_id to send a file that exists on the Telegram servers (recommended),
     * pass an HTTP URL for Telegram to get a file from the Internet,
     * or pass “attach://<file_attach_name>” to upload a new one using multipart/form-data under <file_attach_name> name.
     * {@see https://core.telegram.org/bots/api#sending-files More information on Sending Files »}
     */
    public InputFile|string $media;

    public function __construct(
        InputFile|string $media,
    ) {
        parent::__construct();
        $this->media = $media;
    }

    public function uploadables(): array
    {
        return ['media'];
    }
}
