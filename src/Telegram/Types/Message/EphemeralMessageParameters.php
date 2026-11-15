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
     * Optional.
     * Identifier of the user who will receive the message; required unless the message is sent as an ephemeral reply to a callback query.
     * If omitted, then the parameter chat_id of the method is ignored.
     * If specified together with callback_query_id, then it must be the identifier of the user who pressed the button.
     * Must be omitted for messages sent in chats where the bot isn't a member, unless the message is a reply to an ephemeral message.
     * It is not guaranteed that the user will receive the message, especially if they are offline.
     * See {@see https://core.telegram.org/bots/api#ephemeral-messages-and-commands here} for more details.
     */
    public ?int $receiver_user_id = null;

    /**
     * Optional.
     * Identifier of the callback query which triggered the message, if any.
     * If specified and receiver_user_id is omitted, then the message is sent as an ephemeral
     * reply to the callback query and will be shown only to the user who pressed the button.
     * Ephemeral replies can't be sent to callback queries from messages in channel direct messages chats.
     * The bot must still answer the callback query using {@see https://core.telegram.org/bots/api#answercallbackquery answerCallbackQuery}.
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
        ?int $receiver_user_id = null,
        ?string $callback_query_id = null,
        ?bool $replace_callback_query_message = null,
    ) {
        parent::__construct();
        $this->receiver_user_id = $receiver_user_id;
        $this->callback_query_id = $callback_query_id;
        $this->replace_callback_query_message = $replace_callback_query_message;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
