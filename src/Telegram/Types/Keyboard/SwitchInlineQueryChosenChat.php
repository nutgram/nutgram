<?php

namespace SergiX44\Nutgram\Telegram\Types\Keyboard;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents an inline button that switches the current user to inline mode in a chosen chat,
 * with an optional default inline query.
 * @see https://core.telegram.org/bots/api#switchinlinequerychosenchat
 */
class SwitchInlineQueryChosenChat extends BaseType
{
    /**
     * Optional. The default inline query to be inserted in the input field.
     * If left empty, only the bot's username will be inserted
     */
    public ?string $query = null;

    /**
     * Optional. True, if private chats with users can be chosen
     */
    public ?bool $allow_user_chats = null;

    /**
     * Optional. True, if private chats with bots can be chosen
     */
    public ?bool $allow_bot_chats = null;

    /**
     * Optional. True, if group and supergroup chats can be chosen
     */
    public ?bool $allow_group_chats = null;

    /**
     * Optional. True, if channel chats can be chosen
     */
    public ?bool $allow_channel_chats = null;
}
