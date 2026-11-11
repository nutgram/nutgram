<?php

namespace SergiX44\Nutgram\Telegram\Types\Theme;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\EmojiTypeEmojiType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * A custom emoji.
 * @see https://core.telegram.org/bots/api#emojitypecustomemoji
 */
class EmojiTypeCustomEmoji extends BaseType implements EmojiType
{
    /**
     * Type of the emoji, always “custom_emoji”
     */
    #[EnumOrScalar]
    public EmojiTypeEmojiType|string $type = EmojiTypeEmojiType::CUSTOM_EMOJI;

    /**
     * Identifier of the custom emoji.
     * Use {@see https://core.telegram.org/bots/api#getcustomemojistickers getCustomEmojiStickers}
     * to get full information about the sticker.
     */
    public string $custom_emoji_id;
}
