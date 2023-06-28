<?php

namespace SergiX44\Nutgram\Telegram\Types\Input;

use JsonSerializable;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;
use SergiX44\Nutgram\Telegram\Types\Sticker\MaskPosition;

/**
 * This object describes a sticker to be added to a sticker set.
 * @see https://core.telegram.org/bots/api#inputsticker
 */
class InputSticker extends BaseType implements JsonSerializable
{
    /**
     * The added sticker.
     * Pass a file_id as a String to send a file that already exists on the Telegram servers, pass an HTTP URL as a String for Telegram to get a file from the Internet, upload a new one using multipart/form-data, or pass “attach://<file_attach_name>” to upload a new one using multipart/form-data under <file_attach_name> name.
     * Animated and video stickers can't be uploaded via HTTP URL.
     * {@see https://core.telegram.org/bots/api#sending-files More information on Sending Files »}
     */
    public InputFile|string $sticker;

    /**
     * List of 1-20 emoji associated with the sticker
     * @var string[] $emoji_list
     */
    public array $emoji_list;

    /**
     * Optional.
     * Position where the mask should be placed on faces.
     * For “mask” stickers only.
     */
    public ?MaskPosition $mask_position = null;

    /**
     * Optional.
     * List of 0-20 search keywords for the sticker with total length of up to 64 characters.
     * For “regular” and “custom_emoji” stickers only.
     * @var string[] $keywords
     */
    public ?array $keywords = null;

    public function __construct(
        InputFile|string $sticker,
        array $emoji_list,
        ?MaskPosition $mask_position = null,
        ?array $keywords = null,
    ) {
        parent::__construct();
        $this->sticker = $sticker;
        $this->emoji_list = $emoji_list;
        $this->mask_position = $mask_position;
        $this->keywords = $keywords;
    }

    public static function make(
        InputFile|string $sticker,
        array $emoji_list,
        ?MaskPosition $mask_position = null,
        ?array $keywords = null,
    ): self {
        return new self(
            sticker: $sticker,
            emoji_list: $emoji_list,
            mask_position: $mask_position,
            keywords: $keywords
        );
    }

    public function jsonSerialize(): array
    {
        return array_filter([
            'sticker' => $this->sticker,
            'emoji' => $this->emoji_list,
            'mask_position' => $this->mask_position,
            'keywords' => $this->keywords,
        ]);
    }
}
