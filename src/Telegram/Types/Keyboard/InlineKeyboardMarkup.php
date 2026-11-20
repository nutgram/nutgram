<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Keyboard;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Annotation\OverrideConstructor;
use SergiX44\Nutgram\Telegram\Types\Internal\BaseType;

/**
 * This object represents an {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard} that appears right next to the message it belongs to.
 * @see https://core.telegram.org/bots/api#inlinekeyboardmarkup
 */
#[OverrideConstructor('bindToInstance')]
class InlineKeyboardMarkup extends BaseType
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
        parent::__construct();
        $this->inline_keyboard = [];
        $this->force_reply = $force_reply;
    }

    /**
     * @return InlineKeyboardMarkup
     */
    /**
     * @param InlineKeyboardButton ...$buttons
     */
    public function addRow(...$buttons): static
    {
        $this->inline_keyboard[] = $buttons;
        return $this;
    }
}
