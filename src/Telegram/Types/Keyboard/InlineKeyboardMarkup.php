<?php

namespace SergiX44\Nutgram\Telegram\Types\Keyboard;

use JsonSerializable;

/**
 * This object represents an
 * {@see https://core.telegram.org/bots#inline-keyboards-and-on-the-fly-updating inline keyboard}
 * that appears right next to the message it belongs to.
 *
 * Note: This will only work in Telegram versions released after 9 April, 2016. Older clients will display unsupported message.
 * @see https://core.telegram.org/bots/api#inlinekeyboardmarkup
 */
class InlineKeyboardMarkup implements JsonSerializable
{
    /**
     * Array of button rows, each represented by an Array of
     * {@see https://core.telegram.org/bots/api#inlinekeyboardbutton InlineKeyboardButton} objects
     * @var InlineKeyboardButton[][] $inline_keyboard
     */
    public $inline_keyboard;

    /**
     * @return InlineKeyboardMarkup
     */
    public static function make()
    {
        return new self;
    }

    /**
     * @param  InlineKeyboardButton  ...$buttons
     * @return InlineKeyboardMarkup
     */
    public function addRow(...$buttons): static
    {
        $this->inline_keyboard[] = $buttons;
        return $this;
    }

    /**
     * @return mixed|InlineKeyboardButton[][]
     */
    public function jsonSerialize()
    {
        return ['inline_keyboard' => $this->inline_keyboard ?? []];
    }
}
