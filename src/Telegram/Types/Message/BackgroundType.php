<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Message;

use SergiX44\Nutgram\Telegram\Types\Internal\Resolvers\BackgroundTypeResolver;

/**
 * This object describes the type of a background. Currently, it can be one of
 * - {@see BackgroundTypeFill}
 * - {@see BackgroundTypeWallpaper}
 * - {@see BackgroundTypePattern}
 * - {@see BackgroundTypeChatTheme}
 * @see https://core.telegram.org/bots/api#backgroundtype
 */
#[BackgroundTypeResolver]
interface BackgroundType
{
}
