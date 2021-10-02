<?php

namespace SergiX44\Nutgram\Telegram\Types\Keyboard;

/**
 * This object represents a custom keyboard with reply options (see Introduction to bots for details and examples).
 * @see https://core.telegram.org/bots#keyboards custom keyboard
 * @see https://core.telegram.org/bots#keyboards Introduction to bots
 * @see https://core.telegram.org/bots/api#replykeyboardmarkup
 */
class ReplyKeyboardMarkup
{
    /**
     * Array of button rows, each represented by an Array of KeyboardButton objects
     * @var KeyBoardButton[][] $keyboard
     */
    public $keyboard;

    /**
     * Optional. Requests clients to resize the keyboard vertically for optimal fit
     * (e.g., make the keyboard smaller if there are just two rows of buttons).
     * Defaults to false, in which case the custom keyboard is always of the same height as the app's standard keyboard.
     * @var bool $resize_keyboard
     */
    public $resize_keyboard;

    /**
     * Optional. Requests clients to hide the keyboard as soon as it's been used.
     * The keyboard will still be available, but clients will automatically display the usual
     * letter-keyboard in the chat – the user can press a special button in the input field to
     * see the custom keyboard again.
     * Defaults to false.
     * @var bool $one_time_keyboard
     */
    public $one_time_keyboard;

    /**
     * Optional. The placeholder to be shown in the input field when the keyboard is active; 1-64 characters
     * @var string $input_field_placeholder
     */
    public $input_field_placeholder;

    /**
     * Optional. Use this parameter if you want to show the keyboard to specific users only.
     * Targets:
     * 1) users that are [at]mentioned in the text of the Message object;
     * 2) if the bot's message is a reply (has reply_to_message_id), sender of the original message.
     * Example: A user requests to change the bot‘s language,
     * bot replies to the request with a keyboard to select the new language.
     * Other users in the group don’t see the keyboard.
     * @ee https://core.telegram.org/bots/api#message Message
     * @var bool $selective
     */
    public $selective;
}
