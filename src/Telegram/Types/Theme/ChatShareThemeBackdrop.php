<?php

namespace SergiX44\Nutgram\Telegram\Types\Theme;

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Sticker\UniqueGiftBackdropColors;

/**
 * This object describes a backdrop, which can be used as the background
 * of a theme of the screen for sharing a link to a user or a chat.
 * @see https://core.telegram.org/bots/api#chatsharethemebackdrop
 */
class ChatShareThemeBackdrop extends BaseType
{
    /**
     * Unique identifier of the backdrop
     */
    public int $id;

    /**
     * Name of the backdrop
     */
    public string $name;

    /**
     * Colors of the backdrop
     */
    public UniqueGiftBackdropColors $colors;
}
