<?php

namespace SergiX44\Nutgram\Telegram\Types\Theme;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\EmojiTypeEmojiType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * A regular emoji.
 * @see https://core.telegram.org/bots/api#emojitypeemoji
 */
class EmojiTypeEmoji extends BaseType implements EmojiType
{
    /**
     * Type of the emoji, always “emoji”
     */
    #[EnumOrScalar]
    public EmojiTypeEmojiType|string $type = EmojiTypeEmojiType::EMOJI;

    /**
     * The emoji
     */
    public string $emoji;
}
