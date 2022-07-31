<?php

namespace SergiX44\Nutgram\Telegram\Types\Keyboard;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents an
 * {@see https://core.telegram.org/bots#inline-keyboards-and-on-the-fly-updating inline keyboard}
 * that appears right next to the message it belongs to.
 *
 * Note: This will only work in Telegram versions released after 9 April, 2016. Older clients will display unsupported message.
 * @see https://core.telegram.org/bots/api#inlinekeyboardmarkup
 */
class InlineKeyboardMarkup extends BaseType implements JsonSerializable
{
    /**
     * Array of button rows, each represented by an Array of
     * {@see https://core.telegram.org/bots/api#inlinekeyboardbutton InlineKeyboardButton} objects
     * @var \SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton[][] $inline_keyboard
     */
    #[ArrayType(InlineKeyboardButton::class, depth: 2)]
    public array $inline_keyboard;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return InlineKeyboardMarkup
     */
    public static function make()
    {
        return new self;
    }

    /**
     * @param InlineKeyboardButton  ...$buttons
     */
    public function addRow(...$buttons): static
    {
        $this->inline_keyboard[] = $buttons;
        return $this;
    }


    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return ['inline_keyboard' => $this->inline_keyboard ?? []];
    }
}
