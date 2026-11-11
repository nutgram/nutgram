<?php

namespace SergiX44\Nutgram\Telegram\Types\Theme;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\ChatShareThemeType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Sticker\UniqueGift;

/**
 * The theme based on a unique gift owned by the user or the chat.
 * @see https://core.telegram.org/bots/api#chatsharethemeuniquegift
 */
class ChatShareThemeUniqueGift extends BaseType implements ChatShareTheme
{
    /**
     * Type of the theme, always “unique_gift”
     */
    #[EnumOrScalar]
    public ChatShareThemeType|string $type = ChatShareThemeType::UNIQUE_GIFT;

    /**
     * The gift
     */
    public UniqueGift $gift;
}
