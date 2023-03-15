<?php

namespace SergiX44\Nutgram\Telegram\Types\Input;

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;
use SergiX44\Nutgram\Telegram\Types\Sticker\MaskPosition;

/**
 * Represents the {@see https://core.telegram.org/bots/api#inputmessagecontent content}
 * of a contact message to be sent as the result of an inline query.
 * @see https://core.telegram.org/bots/api#inputcontactmessagecontent
 */
class InputSticker extends BaseType
{
    /**
     * The added sticker. Pass a file_id as a String to send a file that already exists on the Telegram servers,
     * pass an HTTP URL as a String for Telegram to get a file from the Internet,
     * or upload a new one using multipart/form-data.
     * Animated and video stickers can't be uploaded via HTTP URL.
     * More information on Sending Files »
     */
    public InputFile|string $sticker;

    /**
     * List of 1-20 emoji associated with the sticker
     * @var string[] $emoji_list
     */
    public array $emoji_list;

    /**
     * Optional. Position where the mask should be placed on faces. For “mask” stickers only.
     */
    public ?MaskPosition $mask_position = null;

    /**
     * Optional. List of 0-20 search keywords for the sticker with total length of up to 64 characters.
     * For “regular” and “custom_emoji” stickers only.
     * @var string[]|null $keywords
     */
    public ?array $keywords = null;
}
