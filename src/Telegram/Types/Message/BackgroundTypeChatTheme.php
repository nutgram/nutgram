<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Message;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\BackgroundTypeType;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;

/**
 * The background is taken directly from a built-in chat theme.
 * @see https://core.telegram.org/bots/api#backgroundtypechattheme
 */
class BackgroundTypeChatTheme extends BaseType implements BackgroundType
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
