<?php

namespace SergiX44\Nutgram\Telegram\Types\Message;

use JsonSerializable;
use SergiX44\Hydrator\Annotation\SkipConstructor;
use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * Describes the parameters of an ephemeral message.
 * @see https://core.telegram.org/bots/api#ephemeralmessageparameters
 */
#[SkipConstructor]
class EphemeralMessageParameters extends BaseType implements JsonSerializable
{
    /**
     * Identifier of the user who will receive the message.
     * It is not guaranteed that the user will receive the message,
     * especially if they are offline.
     * See {@see https://core.telegram.org/bots/api#ephemeral-messages-and-commands here}
     * for more details.
     */
    public int $receiver_user_id;

    /**
     * Optional.
     * Identifier of the callback query which triggered the message, if any
     */
    public ?string $callback_query_id = null;

    /**
     * Optional.
     * Pass True if the ephemeral message must be shown in place of the original message.
     * Must be False for callback queries from ephemeral messages,
     * which must be edited using regular editEphemeralMessage… methods.
     */
    public ?bool $replace_callback_query_message = null;

    public function __construct(
        int $receiver_user_id,
        ?string $callback_query_id = null,
        ?bool $replace_callback_query_message = null,
    ) {
        $this->receiver_user_id = $receiver_user_id;
        $this->callback_query_id = $callback_query_id;
        $this->replace_callback_query_message = $replace_callback_query_message;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
