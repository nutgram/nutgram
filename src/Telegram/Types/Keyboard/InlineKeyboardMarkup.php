<?php

namespace SergiX44\Nutgram\Telegram\Types\Keyboard;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * This object represents an {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard} that appears right next to the message it belongs to.
 * @see https://core.telegram.org/bots/api#inlinekeyboardmarkup
 */
#[SkipConstructor]
class InlineKeyboardMarkup extends BaseType implements JsonSerializable
{
    /**
     * Array of button rows, each represented by an Array of {@see https://core.telegram.org/bots/api#inlinekeyboardbutton InlineKeyboardButton} objects
     * @var InlineKeyboardButton[][] $inline_keyboard
     */
    #[ArrayType(InlineKeyboardButton::class, depth: 2)]
    public array $inline_keyboard;

    /**
     * Optional. Pass True if the reply interface must be shown to the user,
     * as if they had manually selected the bot's message and tapped 'Reply'.
     * The value of the field can't be changed when the inline keyboard is edited.
     */
    public ?bool $force_reply = null;

    public function __construct(?bool $force_reply = null)
    {
        $this->force_reply = $force_reply;
    }

    /**
     * @return InlineKeyboardMarkup
     */
    public static function make(?bool $force_reply = null)
    {
        return new self($force_reply);
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
        return array_filter_null([
            'inline_keyboard' => $this->inline_keyboard ?? [],
            'force_reply' => $this->force_reply,
        ]);
    }
}
