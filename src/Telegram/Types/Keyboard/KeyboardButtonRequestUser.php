<?php

namespace SergiX44\Nutgram\Telegram\Types\Keyboard;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object defines the criteria used to request a suitable user.
 * The identifier of the selected user will be shared with the bot when the corresponding button is pressed.
 * {@see https://core.telegram.org/bots/features#chat-and-user-selection More about requesting users »}
 * @see https://core.telegram.org/bots/api#keyboardbuttonrequestusers
 * @deprecated Use {@see KeyboardButtonRequestUsers} instead
 */
class KeyboardButtonRequestUser extends BaseType
{
    /**
     * Signed 32-bit identifier of the request, which will be received back in the {@see https://core.telegram.org/bots/api#usershared UserShared} object.
     * Must be unique within the message
     */
    public int $request_id;

    /**
     * Optional.
     * Pass True to request a bot, pass False to request a regular user.
     * If not specified, no additional restrictions are applied.
     */
    public ?bool $user_is_bot = null;

    /**
     * Optional.
     * Pass True to request a premium user, pass False to request a non-premium user.
     * If not specified, no additional restrictions are applied.
     */
    public ?bool $user_is_premium = null;
}
