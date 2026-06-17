<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Input;

use SergiX44\Hydrator\Annotation\OverrideConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\InputMediaType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseUnion;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;
use SergiX44\Nutgram\Telegram\Types\Internal\Uploadables;

/**
 * Represents a sticker file to be sent.
 * @see https://core.telegram.org/bots/api#inputmediasticker
 */
#[OverrideConstructor('bindToInstance')]
class InputMediaSticker extends BaseType implements InputPollOptionMedia, Uploadables
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
    #[BaseUnion]
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

    public function uploadables(): array
    {
        return ['media'];
    }
}
