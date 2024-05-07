<?php

namespace SergiX44\Nutgram\Telegram\Types\Message;

use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\BackgroundTypeType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object describes the type of a background. Currently, it can be one of
 * - {@see BackgroundTypeFill}
 * - {@see BackgroundTypeWallpaper}
 * - {@see BackgroundTypePattern}
 * - {@see BackgroundTypeChatTheme}
 * @see https://core.telegram.org/bots/api#backgroundtype
 */
#[BackgroundTypeResolver]
abstract class BackgroundType extends BaseType
{
    /**
     * Type of the background
     */
    #[EnumOrScalar]
    public BackgroundTypeType|string $type;
}
