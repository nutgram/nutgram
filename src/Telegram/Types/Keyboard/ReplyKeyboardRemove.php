<?php

namespace SergiX44\Nutgram\Telegram\Types\Keyboard;

use JsonSerializable;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * Upon receiving a message with this object, Telegram clients will remove the current custom keyboard and display the default letter-keyboard.
 * By default, custom keyboards are displayed until a new keyboard is sent by a bot.
 * An exception is made for one-time keyboards that are hidden immediately after the user presses a button (see {@see https://core.telegram.org/bots/api#replykeyboardmarkup ReplyKeyboardMarkup}).
 * @see https://core.telegram.org/bots/api#replykeyboardremove
 */
class ReplyKeyboardRemove extends BaseType implements JsonSerializable
{
    /**
     * Requests clients to remove the custom keyboard (user will not be able to summon this keyboard;
     * if you want to hide the keyboard from sight but keep it accessible, use one_time_keyboard in {@see https://core.telegram.org/bots/api#replykeyboardmarkup ReplyKeyboardMarkup})
     */
    public bool $remove_keyboard;

    /**
     * Optional.
     * Use this parameter if you want to remove the keyboard for specific users only.
     * Targets: 1) users that are &#64;mentioned in the text of the {@see https://core.telegram.org/bots/api#message Message} object;
     * 2) if the bot's message is a reply (has reply_to_message_id), sender of the original message.Example: A user votes in a poll, bot returns confirmation message in reply to the vote and removes the keyboard for that user, while still showing the keyboard with poll options to users who haven't voted yet.
     */
    public ?bool $selective = null;

    public function __construct(bool $remove_keyboard, ?bool $selective = null)
    {
        parent::__construct();
        $this->remove_keyboard = $remove_keyboard;
        $this->selective = $selective;
    }

    public static function make(bool $remove_keyboard, ?bool $selective = null): self
    {
        return new self($remove_keyboard, $selective);
    }

    public function jsonSerialize(): array
    {
        return array_filter_null([
            'remove_keyboard' => $this->remove_keyboard,
            'selective' => $this->selective,
        ]);
    }
}
