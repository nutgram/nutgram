<?php

namespace SergiX44\Nutgram\Telegram\Types\Keyboard;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Hydrator\Resolver\EnumOrScalar;
use SergiX44\Nutgram\Telegram\Properties\ButtonStyle;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\WebApp\WebAppInfo;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * This object represents one button of the reply keyboard.
 * At most one of the fields other than text, icon_custom_emoji_id, and style must be used to specify the type of the button.
 * For simple text buttons, String can be used instead of this object to specify the button text.
 * @see https://core.telegram.org/bots/api#keyboardbutton
 */
#[SkipConstructor]
class KeyboardButton extends BaseType implements JsonSerializable
{
    /**
     * Text of the button.
     * If none of the optional fields are used, it will be sent as a message when the button is pressed
     */
    public string $text;

    /**
     * Optional. Unique identifier of the custom emoji shown before the text of the button.
     * Can only be used by bots that purchased additional usernames on {@see https://fragment.com/ Fragment} or
     * in the messages directly sent by the bot to private, group and
     * supergroup chats if the owner of the bot has a Telegram Premium subscription.
     */
    public ?string $icon_custom_emoji_id = null;

    /**
     * Optional. Style of the button.
     * Must be one of “danger” (red), “success” (green) or “primary” (blue).
     * If omitted, then an app-specific style is used.
     */
    #[EnumOrScalar]
    public ButtonStyle|string|null $style = null;

    /**
     * Optional.
     * If specified, pressing the button will open a list of suitable users.
     * Tapping on any user will send their identifier to the bot in a “user_shared” service message.
     * Available in private chats only.
     * @deprecated Use $request_users instead
     */
    public ?KeyboardButtonRequestUser $request_user = null;

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
        ?KeyboardButtonRequestUser $request_user = null,
        ?KeyboardButtonRequestUsers $request_users = null,
        ?KeyboardButtonRequestChat $request_chat = null,
        ?string $icon_custom_emoji_id = null,
        ButtonStyle|string|null $style = null,
    ) {
        parent::__construct();
        $this->text = $text;
        $this->request_contact = $request_contact;
        $this->request_location = $request_location;
        $this->request_poll = $request_poll;
        $this->web_app = $web_app;
        $this->request_user = $request_user;
        $this->request_users = $request_users;
        $this->request_chat = $request_chat;
        $this->icon_custom_emoji_id = $icon_custom_emoji_id;
        $this->style = $style;
    }

    public static function make(
        string $text,
        ?bool $request_contact = null,
        ?bool $request_location = null,
        ?KeyboardButtonPollType $request_poll = null,
        ?WebAppInfo $web_app = null,
        ?KeyboardButtonRequestUser $request_user = null,
        ?KeyboardButtonRequestUsers $request_users = null,
        ?KeyboardButtonRequestChat $request_chat = null,
        ?string $icon_custom_emoji_id = null,
        ButtonStyle|string|null $style = null,
    ): self {
        return new self(
            text: $text,
            request_contact: $request_contact,
            request_location: $request_location,
            request_poll: $request_poll,
            web_app: $web_app,
            request_user: $request_user,
            request_users: $request_users,
            request_chat: $request_chat,
            icon_custom_emoji_id: $icon_custom_emoji_id,
            style: $style,
        );
    }

    public function jsonSerialize(): array
    {
        return array_filter_null([
            'text' => $this->text,
            'icon_custom_emoji_id' => $this->icon_custom_emoji_id,
            'style' => $this->style,
            'request_user' => $this->request_user,
            'request_users' => $this->request_users,
            'request_chat' => $this->request_chat,
            'request_contact' => $this->request_contact,
            'request_location' => $this->request_location,
            'request_poll' => $this->request_poll,
            'web_app' => $this->web_app,
        ]);
    }
}
