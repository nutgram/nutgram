<?php

namespace SergiX44\Nutgram\Telegram\Types\Keyboard;

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Chat\ChatAdministratorRights;

/**
 * This object defines the criteria used to request a suitable chat.
 * The identifier of the selected chat will be shared with the bot when the corresponding button is pressed.
 * @see https://core.telegram.org/bots/api#keyboardbuttonrequestchat
 */
class KeyboardButtonRequestChat extends BaseType
{
    /**
     * Signed 32-bit identifier of the request
     */
    public int $request_id;

    /**
     * Pass True to request a channel chat, pass False to request a group or a supergroup chat.
     */
    public bool $chat_is_channel;

    /**
     * Optional. Pass True to request a forum supergroup, pass False to request a non-forum chat.
     * If not specified, no additional restrictions are applied.
     */
    public ?bool $chat_is_forum = null;

    /**
     * Optional. Pass True to request a supergroup or a channel with a username,
     * pass False to request a chat without a username.
     * If not specified, no additional restrictions are applied.
     */
    public ?bool $chat_has_username = null;

    /**
     * Optional. Pass True to request a chat owned by the user.
     * Otherwise, no additional restrictions are applied.
     */
    public ?bool $chat_is_created = null;

    /**
     * Optional. A JSON-serialized object listing the required administrator rights of the user in the chat.
     * If not specified, no additional restrictions are applied.
     */
    public ?ChatAdministratorRights $user_administrator_rights = null;

    /**
     * Optional. A JSON-serialized object listing the required administrator rights of the bot in the chat.
     * The rights must be a subset of user_administrator_rights. If not specified, no additional restrictions are applied.
     */
    public ?ChatAdministratorRights $bot_administrator_rights = null;

    /**
     * Optional. Pass True to request a chat with the bot as a member.
     * Otherwise, no additional restrictions are applied.
     */
    public ?bool $bot_is_member = null;
}
