<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * This object represents one button of an inline keyboard. You MUST use exactly one of the optional fields.
 * @see https://core.telegram.org/bots/api#inlinekeyboardbutton
 */
class InlineKeyboardButton
{
    /**
     * Label text on the button
     * @var string $text
     */
    public $text;
    
    /**
     * Optional. HTTP or tg:// url to be opened when button is pressed
     * @var string $url
     */
    public $url;
    
    /**
     * Optional. An HTTP URL used to automatically authorize the user.
     * Can be used as a replacement for the {@see https://core.telegram.org/widgets/login Telegram Login Widget}.
     * @var LoginUrl $login_url
     */
    public $login_url;
    
    /**
     * Optional. Data to be sent in a {@see https://core.telegram.org/bots/api#callbackquery callback}
     * query to the bot when button is pressed, 1-64 bytes
     * @var string $callback_data
     */
    public $callback_data;
    
    /**
     * Optional. If set, pressing the button will prompt the user to select one of their chats,
     * open that chat and insert the bot‘s username and the specified
     * {@see https://core.telegram.org/bots/inline inline mode} in the input field.
     * Can be empty, in which case just the bot’s username will be inserted.
     *
     * Note: This offers an easy way for users to start using your bot
     * in inline mode when they are currently in a private chat with it.
     * Especially useful when combined with {@see https://core.telegram.org/bots/api#answerinlinequery switch_pm}… actions – in this case the
     * user will be automatically returned to the chat they switched from, skipping the chat selection screen.
     * @var string $switch_inline_query
     */
    public $switch_inline_query;
    
    /**
     * Optional. If set, pressing the button will insert the bot‘s username
     * and the specified inline query in the current chat's input field.
     * Can be empty, in which case only the bot’s username will be inserted.
     * This offers a quick way for the user to open your bot in
     * inline mode in the same chat – good for selecting something from multiple options.
     * @var string $switch_inline_query_current_chat
     */
    public $switch_inline_query_current_chat;
    
    /**
     * Optional. Description of the game that will be launched when the user presses the button.
     *
     * NOTE: This type of button MUST always be the first button in the first row.
     * @var CallbackGame $callback_game
     */
    public $callback_game;
    
    /**
     * Optional. Specify True, to send a Pay button.
     *
     * NOTE: This type of button MUST always be the first button in the first row.
     * @var bool $pay
     */
    public $pay;
}
