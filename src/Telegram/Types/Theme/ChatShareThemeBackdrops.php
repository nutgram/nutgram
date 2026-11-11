<?php

namespace SergiX44\Nutgram\Telegram\Types\Theme;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object contains a list of backdrops,
 * which can be used as the background of a theme of the screen
 * for sharing a link to a user or a chat.
 * @see https://core.telegram.org/bots/api#chatsharethemebackdrop
 */
class ChatShareThemeBackdrops extends BaseType
{
    /**
     * The list of backdrops
     * @var ChatShareThemeBackdrop[]
     */
    #[ArrayType(ChatShareThemeBackdrop::class)]
    public array $backdrops;
}
