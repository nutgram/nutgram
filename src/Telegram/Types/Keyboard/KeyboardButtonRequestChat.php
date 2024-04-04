<?php

namespace SergiX44\Nutgram\Telegram\Types\Keyboard;

use JsonSerializable;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Chat\ChatAdministratorRights;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * This object defines the criteria used to request a suitable chat.
 * The identifier of the selected chat will be shared with the bot when the corresponding button is pressed.
 * {@see https://core.telegram.org/bots/features#chat-and-user-selection More about requesting chats »}
 * @see https://core.telegram.org/bots/api#keyboardbuttonrequestchat
 */
class KeyboardButtonRequestChat extends BaseType implements JsonSerializable
{
    /**
     * Signed 32-bit identifier of the request, which will be received back in the {@see https://core.telegram.org/bots/api#chatshared ChatShared} object.
     * Must be unique within the message
     */
    public int $request_id;

    /** Pass True to request a channel chat, pass False to request a group or a supergroup chat. */
    public bool $chat_is_channel;

    /**
     * Optional.
     * Pass True to request a forum supergroup, pass False to request a non-forum chat.
     * If not specified, no additional restrictions are applied.
     */
    public ?bool $chat_is_forum = null;

    /**
     * Optional.
     * Pass True to request a supergroup or a channel with a username, pass False to request a chat without a username.
     * If not specified, no additional restrictions are applied.
     */
    public ?bool $chat_has_username = null;

    /**
     * Optional.
     * Pass True to request a chat owned by the user.
     * Otherwise, no additional restrictions are applied.
     */
    public ?bool $chat_is_created = null;

    /**
     * Optional.
     * A JSON-serialized object listing the required administrator rights of the user in the chat.
     * The rights must be a superset of bot_administrator_rights.
     * If not specified, no additional restrictions are applied.
     */
    public ?ChatAdministratorRights $user_administrator_rights = null;

    /**
     * Optional.
     * A JSON-serialized object listing the required administrator rights of the bot in the chat.
     * The rights must be a subset of user_administrator_rights.
     * If not specified, no additional restrictions are applied.
     */
    public ?ChatAdministratorRights $bot_administrator_rights = null;

    /**
     * Optional.
     * Pass True to request a chat with the bot as a member.
     * Otherwise, no additional restrictions are applied.
     */
    public ?bool $bot_is_member = null;

    /**
     * Optional. Pass True to request the chat's title
     */
    public ?bool $request_title = null;

    /**
     * Optional. Pass True to request the chat's username
     */
    public ?bool $request_username = null;

    /**
     * Optional. Pass True to request the chat's photo
     */
    public ?bool $request_photo = null;

    public function __construct(
        int $request_id,
        bool $chat_is_channel,
        ?bool $chat_is_forum = null,
        ?bool $chat_has_username = null,
        ?bool $chat_is_created = null,
        ?ChatAdministratorRights $user_administrator_rights = null,
        ?ChatAdministratorRights $bot_administrator_rights = null,
        ?bool $bot_is_member = null,
        ?bool $request_title = null,
        ?bool $request_username = null,
        ?bool $request_photo = null,
    ) {
        parent::__construct();
        $this->request_id = $request_id;
        $this->chat_is_channel = $chat_is_channel;
        $this->chat_is_forum = $chat_is_forum;
        $this->chat_has_username = $chat_has_username;
        $this->chat_is_created = $chat_is_created;
        $this->user_administrator_rights = $user_administrator_rights;
        $this->bot_administrator_rights = $bot_administrator_rights;
        $this->bot_is_member = $bot_is_member;
        $this->request_title = $request_title;
        $this->request_username = $request_username;
        $this->request_photo = $request_photo;
    }

    public static function make(
        int $request_id,
        bool $chat_is_channel,
        ?bool $chat_is_forum = null,
        ?bool $chat_has_username = null,
        ?bool $chat_is_created = null,
        ?ChatAdministratorRights $user_administrator_rights = null,
        ?ChatAdministratorRights $bot_administrator_rights = null,
        ?bool $bot_is_member = null,
        ?bool $request_title = null,
        ?bool $request_username = null,
        ?bool $request_photo = null,
    ): self {
        return new self(
            request_id: $request_id,
            chat_is_channel: $chat_is_channel,
            chat_is_forum: $chat_is_forum,
            chat_has_username: $chat_has_username,
            chat_is_created: $chat_is_created,
            user_administrator_rights: $user_administrator_rights,
            bot_administrator_rights: $bot_administrator_rights,
            bot_is_member: $bot_is_member,
            request_title: $request_title,
            request_username: $request_username,
            request_photo: $request_photo,
        );
    }

    public function jsonSerialize(): array
    {
        return array_filter_null([
            'request_id' => $this->request_id,
            'chat_is_channel' => $this->chat_is_channel,
            'chat_is_forum' => $this->chat_is_forum,
            'chat_has_username' => $this->chat_has_username,
            'chat_is_created' => $this->chat_is_created,
            'user_administrator_rights' => $this->user_administrator_rights,
            'bot_administrator_rights' => $this->bot_administrator_rights,
            'bot_is_member' => $this->bot_is_member,
            'request_title' => $this->request_title,
            'request_username' => $this->request_username,
            'request_photo' => $this->request_photo,
        ]);
    }
}
