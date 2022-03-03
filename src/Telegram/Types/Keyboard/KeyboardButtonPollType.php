<?php

namespace SergiX44\Nutgram\Telegram\Types\Keyboard;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents type of a poll, which is allowed to be created
 * and sent when the corresponding button is pressed.
 * @see https://core.telegram.org/bots/api#keyboardbuttonpolltype
 */
class KeyboardButtonPollType extends BaseType
{
    /**
     * Optional. If quiz is passed, the user will be allowed to create only polls in the quiz mode.
     * If regular is passed, only regular polls will be allowed.
     * Otherwise, the user will be allowed to create a poll of any type.
     */
    public ?string $type = null;
}
