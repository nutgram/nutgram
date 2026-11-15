<?php

namespace SergiX44\Nutgram\Telegram\Types\Theme;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\ChatShareThemeType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * The theme with emoji placed on a background.
 * @see https://core.telegram.org/bots/api#chatsharethemeemoji
 */
class ChatShareThemeEmoji extends BaseType implements ChatShareTheme
{
    /**
     * Type of the theme, always “emoji”
     */
    #[EnumOrScalar]
    public ChatShareThemeType|string $type = ChatShareThemeType::EMOJI;

    /**
     * The emoji; 0-6 regular or custom emoji
     * @var EmojiType[]
     */
    #[ArrayType(EmojiType::class)]
    public array $emojis;

    /**
     * Optional.
     * Identifier of the backdrop used as the background;
     * omitted if the default background is used.
     * Use {@see https://core.telegram.org/bots/api#getchatsharethemebackdrops getChatShareThemeBackdrops}
     * to get details about the backdrop.
     */
    public ?int $background_backdrop_id = null;
}
