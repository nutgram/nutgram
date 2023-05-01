<?php

namespace SergiX44\Nutgram\Telegram\Types\Keyboard;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents an {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard} that appears right next to the message it belongs to.
 * @see https://core.telegram.org/bots/api#inlinekeyboardmarkup
 */
class InlineKeyboardMarkup extends BaseType implements JsonSerializable
{
    /**
     * Array of button rows, each represented by an Array of {@see https://core.telegram.org/bots/api#inlinekeyboardbutton InlineKeyboardButton} objects
     * @var InlineKeyboardButton[][] $inline_keyboard
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
