<?php

namespace SergiX44\Nutgram\Telegram\Types\Message;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\BackgroundTypeType;

/**
 * The background is taken directly from a built-in chat theme.
 * @see https://core.telegram.org/bots/api#backgroundtypechattheme
 */
class BackgroundTypeChatTheme extends BackgroundType
{
    /**
     * Type of the background, always “chat_theme”
     */
    #[EnumOrScalar]
    public BackgroundTypeType|string $type = BackgroundTypeType::CHAT_THEME;

    /**
     * Name of the chat theme, which is usually an emoji
     */
    public string $theme_name;
}
