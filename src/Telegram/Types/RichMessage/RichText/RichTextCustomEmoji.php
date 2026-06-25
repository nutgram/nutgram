<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\RichMessage\RichText;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\RichTextType;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;

/**
 * A custom emoji.
 * @see https://core.telegram.org/bots/api#richtextcustomemoji
 */
class RichTextCustomEmoji extends BaseType implements RichText
{
    /**
     * Type of the rich text, always “custom_emoji”
     */
    #[EnumOrScalar]
    public RichTextType|string $type = RichTextType::CUSTOM_EMOJI;

    /**
     * Unique identifier of the custom emoji.
     * Use {@see https://core.telegram.org/bots/api#getcustomemojistickers getCustomEmojiStickers} to get full information about the sticker.
     */
    public string $custom_emoji_id;

    /**
     * Alternative emoji for the custom emoji
     */
    public string $alternative_text;
}
