<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * This object represents one button of the reply keyboard.
 * For simple text buttons String can be used instead of this object to specify text of the button.
 * Optional fields are mutually exclusive.
 *
 * Note: request_contact and request_location options will only work in Telegram versions released after 9 April, 2016.
 * Older clients will ignore them.
 * @see https://core.telegram.org/bots/api#keyboardbutton
 */
class KeyboardButton
{
    /**
     * Text of the button.
     * If none of the optional fields are used, it will be sent to the bot as a message when the button is pressed
     * @var string $text
     */
    public $text;
    
    /**
     * Optional. If True, the user's phone number will be sent as a contact when the button is pressed.
     * Available in private chats only
     * @var bool $request_contact
     */
    public $request_contact;
    
    /**
     * Optional. If True, the user's current location will be sent when the button is pressed.
     * Available in private chats only
     * @var bool $request_location
     */
    public $request_location;
    
    /**
     * Optional. If specified, the user will be asked to create a poll and send it to the bot when the button is pressed.
     * Available in private chats only
     * @var KeyboardButtonPollType $request_poll
     */
    public $request_poll;
}
