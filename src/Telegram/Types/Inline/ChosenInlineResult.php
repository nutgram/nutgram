<?php

namespace SergiX44\Nutgram\Telegram\Types\Inline;

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Location\Location;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * Represents a {@see https://core.telegram.org/bots/api#inlinequeryresult result} of an inline query that was chosen by the user and sent to their chat partner.
 * @see https://core.telegram.org/bots/api#choseninlineresult
 */
class ChosenInlineResult extends BaseType
{
    /** The unique identifier for the result that was chosen */
    public string $result_id;

    /** The user that chose the result */
    public User $from;

    /**
     * Optional.
     * Sender location, only for bots that require user location
     */
    public ?Location $location = null;

    /**
     * Optional.
     * Identifier of the sent inline message.
     * Available only if there is an {@see https://core.telegram.org/bots/api#inlinekeyboardmarkup inline keyboard} attached to the message.
     * Will be also received in {@see https://core.telegram.org/bots/api#callbackquery callback queries} and can be used to {@see https://core.telegram.org/bots/api#updating-messages edit} the message.
     */
    public ?string $inline_message_id = null;

    /** The query that was used to obtain the result */
    public string $query;
}
