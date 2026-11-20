<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Theme;

use SergiX44\Nutgram\Telegram\Types\Internal\Resolvers\EmojiTypeResolver;

/**
 * This object describes an emoji. Currently, it can be one of
 * - {@see EmojiTypeEmoji}
 * - {@see EmojiTypeCustomEmoji}
 * @see https://core.telegram.org/bots/api#emojitype
 */
#[EmojiTypeResolver]
interface EmojiType
{
}
