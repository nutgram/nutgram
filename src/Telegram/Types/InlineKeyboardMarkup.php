<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * This object represents an
 * {@see https://core.telegram.org/bots#inline-keyboards-and-on-the-fly-updating inline keyboard}
 * that appears right next to the message it belongs to.
 *
 * Note: This will only work in Telegram versions released after 9 April, 2016. Older clients will display unsupported message.
 * @see https://core.telegram.org/bots/api#inlinekeyboardmarkup
 */
class InlineKeyboardMarkup
{
    /**
     * Array of button rows, each represented by an Array of
     * {@see https://core.telegram.org/bots/api#inlinekeyboardbutton InlineKeyboardButton} objects
     * @var InlineKeyboardButton[][]
     */
    public array $inline_keyboard;
}
