<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Theme;

use SergiX44\Nutgram\Telegram\Types\Internal\Resolvers\ChatShareThemeResolver;

/**
 * This object describes the theme of the screen for sharing a link to a user or a chat. Currently, it can be one of
 * - {@see ChatShareThemeEmoji}
 * - {@see ChatShareThemeUniqueGift}
 * @see https://core.telegram.org/bots/api#chatsharetheme
 */
#[ChatShareThemeResolver]
interface ChatShareTheme
{
}
