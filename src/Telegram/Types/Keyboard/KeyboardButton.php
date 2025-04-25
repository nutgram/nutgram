<?php

declare(strict_types=1);

namespace SergiX44\Nutgram\Telegram\Types\Keyboard;

use SergiX44\Hydrator\Annotation\OverrideConstructor;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\WebApp\WebAppInfo;

/**
 * This object represents one button of the reply keyboard.
 * For simple text buttons, String can be used instead of this object to specify the button text.
 * The optional fields web_app, request_user, request_chat, request_contact, request_location, and request_poll are mutually exclusive.
 * @see https://core.telegram.org/bots/api#keyboardbutton
 */
#[OverrideConstructor('bindToInstance')]
class KeyboardButton extends BaseType
{
    /**
     * Text of the button.
     * If none of the optional fields are used, it will be sent as a message when the button is pressed
     */
    public string $text;

    /**
     * Optional. If specified, pressing the button will open a list of suitable users.
     * Identifiers of selected users will be sent to the bot in a “users_shared” service message.
     * Available in private chats only.
     */
    public ?KeyboardButtonRequestUsers $request_users = null;

    /**
     * Optional.
     * If specified, pressing the button will open a list of suitable chats.
     * Tapping on a chat will send its identifier to the bot in a “chat_shared” service message.
     * Available in private chats only.
     */
    public ?KeyboardButtonRequestChat $request_chat = null;

    /**
     * Optional.
     * If True, the user's phone number will be sent as a contact when the button is pressed.
     * Available in private chats only.
     */
    public ?bool $request_contact = null;

    /**
     * Optional.
     * If True, the user's current location will be sent when the button is pressed.
     * Available in private chats only.
     */
    public ?bool $request_location = null;

    /**
     * Optional.
     * If specified, the user will be asked to create a poll and send it to the bot when the button is pressed.
     * Available in private chats only.
     */
    public ?KeyboardButtonPollType $request_poll = null;

    /**
     * Optional.
     * If specified, the described {@see https://core.telegram.org/bots/webapps Web App} will be launched when the button is pressed.
     * The Web App will be able to send a “web_app_data” service message.
     * Available in private chats only.
     */
    public ?WebAppInfo $web_app = null;

    public function __construct(
        string $text,
        ?bool $request_contact = null,
        ?bool $request_location = null,
        ?KeyboardButtonPollType $request_poll = null,
        ?WebAppInfo $web_app = null,
        ?KeyboardButtonRequestUsers $request_users = null,
        ?KeyboardButtonRequestChat $request_chat = null,
    ) {
        parent::__construct();
        $this->text = $text;
        $this->request_contact = $request_contact;
        $this->request_location = $request_location;
        $this->request_poll = $request_poll;
        $this->web_app = $web_app;
        $this->request_users = $request_users;
        $this->request_chat = $request_chat;
    }
}
