<?php

namespace SergiX44\Nutgram\Telegram\Types\RichMessage;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Nutgram\Telegram\Properties\ButtonStyle;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Common\LoginUrl;
use SergiX44\Nutgram\Telegram\Types\Keyboard\CopyTextButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\DisabledButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\SwitchInlineQueryChosenChat;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichText;
use SergiX44\Nutgram\Telegram\Types\RichMessage\RichText\RichTextUnionResolver;
use SergiX44\Nutgram\Telegram\Types\WebApp\WebAppInfo;

/**
 * This object represents a button in a {@see https://core.telegram.org/bots/api#richmessage RichMessage}.
 * Exactly one of the fields other than text and style must be used to specify the type of the button.
 * @see https://core.telegram.org/bots/api#richmessagebutton
 */
#[SkipConstructor]
class RichMessageButton extends BaseType implements JsonSerializable
{
    /**
     * Text of the button.
     * May contain only plain text,
     * {@see https://core.telegram.org/bots/api#richtextcustomemoji RichTextCustomEmoji} and
     * {@see https://core.telegram.org/bots/api#richtextdatetime RichTextDateTime} entities.
     */
    #[ArrayType(RichText::class, skipScalars: true)]
    #[RichTextUnionResolver]
    public string|array|RichText $text;

    /**
     * Optional. Style of the button.
     * Must be one of “danger” (red), “success” (green), “primary” (blue) or “link” (the button is shown as a regular link without borders).
     * If omitted, then an app-specific style is used.
     * The style “link” is allowed only for callback buttons.
     */
    public ButtonStyle|string|null $style = null;

    /**
     * Optional. HTTP or tg:// URL to be opened when the button is pressed.
     * Links `tg://user?id=<user_id>` can be used to mention a user by their identifier without using a username, if this is allowed by their privacy settings.
     */
    public ?string $url = null;

    /**
     * Optional. Data to be sent in a
     * {@see https://core.telegram.org/bots/api#callbackquery callback query}
     * to the bot when the button is pressed, 1-64 bytes
     */
    public ?string $callback_data = null;

    /**
     * Optional. Description of the {@see https://core.telegram.org/bots/webapps Web App}
     * that will be launched when the user presses the button.
     * The Web App will be able to send an arbitrary message on behalf of the user
     * using the method {@see https://core.telegram.org/bots/api#answerwebappquery answerWebAppQuery}.
     * Available only in private chats between a user and the bot.
     * Not supported for messages sent on behalf of a business account.
     */
    public ?WebAppInfo $web_app = null;

    /**
     * Optional. An HTTPS URL used to automatically authorize the user.
     * Can be used as a replacement for the {@see https://core.telegram.org/widgets/login Telegram Login Widget}.
     * Not supported for ephemeral messages.
     */
    public ?LoginUrl $login_url = null;

    /**
     * Optional. If set, pressing the button will prompt the user to select one of their chats, open that chat and insert the bot's username and the specified inline query in the input field.
     * May be empty, in which case just the bot's username will be inserted.
     * Not supported for messages sent in channel direct messages chats and on behalf of a business account.
     */
    public ?string $switch_inline_query = null;

    /**
     * Optional. If set, pressing the button will insert the bot's username and the specified inline query in the current chat's input field.
     * May be empty, in which case only the bot's username will be inserted.
     * Not supported in channels and for messages sent in channel direct messages chats and on behalf of a business account.
     */
    public ?string $switch_inline_query_current_chat = null;

    /**
     * Optional. If set, pressing the button will prompt the user to select one of their chats of the specified type, open that chat and insert the bot's username and the specified inline query in the input field.
     * Not supported for messages sent in channel direct messages chats and on behalf of a business account.
     */
    public ?SwitchInlineQueryChosenChat $switch_inline_query_chosen_chat = null;

    /**
     * Optional. A button that copies the specified text to the clipboard
     */
    public ?CopyTextButton $copy_text = null;

    /**
     * Optional. If set, then the button is disabled and does nothing
     */
    public ?DisabledButton $disabled = null;

    public function __construct(
        string|array|RichText $text,
        ButtonStyle|string|null $style = null,
        ?string $url = null,
        ?string $callback_data = null,
        ?WebAppInfo $web_app = null,
        ?LoginUrl $login_url = null,
        ?string $switch_inline_query = null,
        ?string $switch_inline_query_current_chat = null,
        ?SwitchInlineQueryChosenChat $switch_inline_query_chosen_chat = null,
        ?CopyTextButton $copy_text = null,
        ?DisabledButton $disabled = null,
    ) {
        $this->text = $text;
        $this->style = $style;
        $this->url = $url;
        $this->callback_data = $callback_data;
        $this->web_app = $web_app;
        $this->login_url = $login_url;
        $this->switch_inline_query = $switch_inline_query;
        $this->switch_inline_query_current_chat = $switch_inline_query_current_chat;
        $this->switch_inline_query_chosen_chat = $switch_inline_query_chosen_chat;
        $this->copy_text = $copy_text;
        $this->disabled = $disabled;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
