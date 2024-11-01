<?php

namespace SergiX44\Nutgram\Telegram\Types\Keyboard;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Common\LoginUrl;
use SergiX44\Nutgram\Telegram\Types\Game\CallbackGame;
use SergiX44\Nutgram\Telegram\Types\WebApp\WebAppInfo;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * This object represents one button of an inline keyboard.
 * You must use exactly one of the optional fields.
 * @see https://core.telegram.org/bots/api#inlinekeyboardbutton
 */
#[SkipConstructor]
class InlineKeyboardButton extends BaseType implements JsonSerializable
{
    /** Label text on the button */
    public string $text;

    /**
     * Optional.
     * HTTP or tg:// URL to be opened when the button is pressed.
     * Links tg://user?id=<user_id> can be used to mention a user by their ID without using a username, if this is allowed by their privacy settings.
     */
    public ?string $url = null;

    /**
     * Optional.
     * Data to be sent in a {@see https://core.telegram.org/bots/api#callbackquery callback query} to the bot when button is pressed, 1-64 bytes
     */
    public ?string $callback_data = null;

    /**
     * Optional.
     * Description of the {@see https://core.telegram.org/bots/webapps Web App} that will be launched when the user presses the button.
     * The Web App will be able to send an arbitrary message on behalf of the user using the method {@see https://core.telegram.org/bots/api#answerwebappquery answerWebAppQuery}.
     * Available only in private chats between a user and the bot.
     */
    public ?WebAppInfo $web_app = null;

    /**
     * Optional.
     * An HTTPS URL used to automatically authorize the user.
     * Can be used as a replacement for the {@see https://core.telegram.org/widgets/login Telegram Login Widget}.
     */
    public ?LoginUrl $login_url = null;

    /**
     * Optional.
     * If set, pressing the button will prompt the user to select one of their chats, open that chat and insert the bot's username and the specified inline query in the input field.
     * May be empty, in which case just the bot's username will be inserted.Note: This offers an easy way for users to start using your bot in {@see https://core.telegram.org/bots/inline inline mode} when they are currently in a private chat with it.
     * Especially useful when combined with {@see https://core.telegram.org/bots/api#answerinlinequery switch_pm…} actions - in this case the user will be automatically returned to the chat they switched from, skipping the chat selection screen.
     */
    public ?string $switch_inline_query = null;

    /**
     * Optional.
     * If set, pressing the button will insert the bot's username and the specified inline query in the current chat's input field.
     * May be empty, in which case only the bot's username will be inserted.This offers a quick way for the user to open your bot in inline mode in the same chat - good for selecting something from multiple options.
     */
    public ?string $switch_inline_query_current_chat = null;

    /**
     * Optional.
     * If set, pressing the button will prompt the user to select one of their chats of the specified type, open that chat and insert the bot's username and the specified inline query in the input field
     */
    public ?SwitchInlineQueryChosenChat $switch_inline_query_chosen_chat = null;

    /**
     * Optional.
     * Description of the button that copies the specified text to the clipboard.
     */
    public ?CopyTextButton $copy_text = null;

    /**
     * Optional.
     * Description of the game that will be launched when the user presses the button.NOTE: This type of button must always be the first button in the first row.
     */
    public ?CallbackGame $callback_game = null;

    /**
     * Optional.
     * Specify True, to send a {@see https://core.telegram.org/bots/api#payments Pay button}.
     * Substrings “⭐” and “XTR” in the buttons's text will be replaced with a Telegram Star icon.
     * NOTE: This type of button must always be the first button in the first row and can only be used in invoice messages.
     */
    public ?bool $pay = null;

    public function __construct(
        string $text,
        ?string $url = null,
        ?LoginUrl $login_url = null,
        ?string $callback_data = null,
        ?string $switch_inline_query = null,
        ?string $switch_inline_query_current_chat = null,
        ?CallbackGame $callback_game = null,
        ?bool $pay = null,
        ?WebAppInfo $web_app = null,
        ?SwitchInlineQueryChosenChat $switch_inline_query_chosen_chat = null,
        ?CopyTextButton $copy_text = null,
    ) {
        parent::__construct();
        $this->text = $text;
        $this->url = $url;
        $this->login_url = $login_url;
        $this->callback_data = $callback_data;
        $this->switch_inline_query = $switch_inline_query;
        $this->switch_inline_query_current_chat = $switch_inline_query_current_chat;
        $this->callback_game = $callback_game;
        $this->pay = $pay;
        $this->web_app = $web_app;
        $this->switch_inline_query_chosen_chat = $switch_inline_query_chosen_chat;
        $this->copy_text = $copy_text;
    }

    public static function make(
        string $text = '',
        ?string $url = null,
        ?LoginUrl $login_url = null,
        ?string $callback_data = null,
        ?string $switch_inline_query = null,
        ?string $switch_inline_query_current_chat = null,
        ?CallbackGame $callback_game = null,
        ?bool $pay = null,
        ?WebAppInfo $web_app = null,
        ?SwitchInlineQueryChosenChat $switch_inline_query_chosen_chat = null,
        ?CopyTextButton $copy_text = null,
    ): InlineKeyboardButton {
        return new self(
            $text,
            $url,
            $login_url,
            $callback_data,
            $switch_inline_query,
            $switch_inline_query_current_chat,
            $callback_game,
            $pay,
            $web_app,
            $switch_inline_query_chosen_chat,
            $copy_text,
        );
    }

    public function jsonSerialize(): array
    {
        return array_filter_null([
            'text' => $this->text,
            'url' => $this->url,
            'login_url' => $this->login_url,
            'callback_data' => $this->callback_data,
            'switch_inline_query' => $this->switch_inline_query,
            'switch_inline_query_current_chat' => $this->switch_inline_query_current_chat,
            'switch_inline_query_chosen_chat' => $this->switch_inline_query_chosen_chat,
            'callback_game' => $this->callback_game,
            'pay' => $this->pay,
            'web_app' => $this->web_app,
            'copy_text' => $this->copy_text,
        ]);
    }
}
