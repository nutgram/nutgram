<?php

namespace SergiX44\Nutgram\Telegram\Types\Keyboard;

use JsonSerializable;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * This object represents an inline button that switches the current user to inline mode in a chosen chat, with an optional default inline query.
 * @see https://core.telegram.org/bots/api#switchinlinequerychosenchat
 */
class SwitchInlineQueryChosenChat extends BaseType implements JsonSerializable
{
    /**
     * Optional.
     * The default inline query to be inserted in the input field.
     * If left empty, only the bot's username will be inserted
     */
    public ?string $query = null;

    /**
     * Optional.
     * True, if private chats with users can be chosen
     */
    public ?bool $allow_user_chats = null;

    /**
     * Optional.
     * True, if private chats with bots can be chosen
     */
    public ?bool $allow_bot_chats = null;

    /**
     * Optional.
     * True, if group and supergroup chats can be chosen
     */
    public ?bool $allow_group_chats = null;

    /**
     * Optional.
     * True, if channel chats can be chosen
     */
    public ?bool $allow_channel_chats = null;

    public function __construct(
        ?string $query = null,
        ?bool $allow_user_chats = null,
        ?bool $allow_bot_chats = null,
        ?bool $allow_group_chats = null,
        ?bool $allow_channel_chats = null,
    ) {
        parent::__construct();
        $this->query = $query;
        $this->allow_user_chats = $allow_user_chats;
        $this->allow_bot_chats = $allow_bot_chats;
        $this->allow_group_chats = $allow_group_chats;
        $this->allow_channel_chats = $allow_channel_chats;
    }

    public static function make(
        ?string $query = null,
        ?bool $allow_user_chats = null,
        ?bool $allow_bot_chats = null,
        ?bool $allow_group_chats = null,
        ?bool $allow_channel_chats = null,
    ): self {
        return new self(
            query: $query,
            allow_user_chats: $allow_user_chats,
            allow_bot_chats: $allow_bot_chats,
            allow_group_chats: $allow_group_chats,
            allow_channel_chats: $allow_channel_chats,
        );
    }

    public function jsonSerialize(): array
    {
        return array_filter_null([
            'query' => $this->query,
            'allow_user_chats' => $this->allow_user_chats,
            'allow_bot_chats' => $this->allow_bot_chats,
            'allow_group_chats' => $this->allow_group_chats,
            'allow_channel_chats' => $this->allow_channel_chats,
        ]);
    }
}
