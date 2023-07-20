<?php

namespace SergiX44\Nutgram\Telegram\Types\Keyboard;

use JsonSerializable;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use function SergiX44\Nutgram\Support\array_filter_null;

/**
 * Upon receiving a message with this object, Telegram clients will display a reply interface to the user (act as if the user has selected the bot's message and tapped 'Reply').
 * This can be extremely useful if you want to create user-friendly step-by-step interfaces without having to sacrifice {@see https://core.telegram.org/bots/features#privacy-mode privacy mode}.
 * @see https://core.telegram.org/bots/api#forcereply
 */
class ForceReply extends BaseType implements JsonSerializable
{
    /** Shows reply interface to the user, as if they manually selected the bot's message and tapped 'Reply' */
    public bool $force_reply;

    /**
     * Optional.
     * The placeholder to be shown in the input field when the reply is active;
     * 1-64 characters
     */
    public ?string $input_field_placeholder = null;

    /**
     * Optional.
     * Use this parameter if you want to force reply from specific users only.
     * Targets: 1) users that are &#64;mentioned in the text of the {@see https://core.telegram.org/bots/api#message Message} object;
     * 2) if the bot's message is a reply (has reply_to_message_id), sender of the original message.
     */
    public ?bool $selective = null;

    public function __construct(bool $force_reply, ?string $input_field_placeholder = null, ?bool $selective = null)
    {
        parent::__construct();
        $this->force_reply = $force_reply;
        $this->input_field_placeholder = $input_field_placeholder;
        $this->selective = $selective;
    }

    public static function make(
        bool $force_reply,
        ?string $input_field_placeholder = null,
        ?bool $selective = null,
    ): ForceReply {
        return new self(
            $force_reply,
            $input_field_placeholder,
            $selective
        );
    }

    public function jsonSerialize(): array
    {
        return array_filter_null([
            'force_reply' => $this->force_reply,
            'input_field_placeholder' => $this->input_field_placeholder,
            'selective' => $this->selective,
        ]);
    }
}
