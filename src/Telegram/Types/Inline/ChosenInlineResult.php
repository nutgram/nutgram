<?php

namespace SergiX44\Nutgram\Telegram\Types\Inline;

use SergiX44\Nutgram\Telegram\Types\Location\Location;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * Represents a result of an inline query that was chosen by the user and sent to their chat partner.
 * Note: It is necessary to enable {@see https://core.telegram.org/bots/inline#collecting-feedback inline feedback}
 * via {@see https://t.me/botfather @Botfather} in order to receive these objects in updates.
 * @see https://core.telegram.org/bots/api#choseninlineresult
 */
class ChosenInlineResult
{
    /**
     * The unique identifier for the result that was chosen
     * @var string $result_id
     */
    public $result_id;

    /**
     * The user that chose the result
     * @var User $from
     */
    public $from;

    /**
     * Optional. Sender location, only for bots that require user location
     * @var Location $location
     */
    public $location;

    /**
     * Optional. Identifier of the sent inline message.
     * Available only if there is an {@see https://core.telegram.org/bots/api#inlinekeyboardmarkup inline keyboard}
     * attached to the message.
     * Will be also received in {@see https://core.telegram.org/bots/api#callbackquery callback} queries
     * and can be used to {@see https://core.telegram.org/bots/api#updating-messages edit} the message.
     * @var string $inline_message_id
     */
    public $inline_message_id;

    /**
     * The query that was used to obtain the result
     * @var string $query
     */
    public $query;
}
