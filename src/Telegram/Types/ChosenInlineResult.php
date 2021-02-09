<?php

namespace SergiX44\Nutgram\Telegram\Types;

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
     * @var string
     */
    public string $result_id;
    
    /**
     * The user that chose the result
     * @var User
     */
    public User $from;
    
    /**
     * Optional. Sender location, only for bots that require user location
     * @var Location
     */
    public Location $location;
    
    /**
     * Optional. Identifier of the sent inline message.
     * Available only if there is an {@see https://core.telegram.org/bots/api#inlinekeyboardmarkup inline keyboard}
     * attached to the message.
     * Will be also received in {@see https://core.telegram.org/bots/api#callbackquery callback} queries
     * and can be used to {@see https://core.telegram.org/bots/api#updating-messages edit} the message.
     * @var string
     */
    public string $inline_message_id;
    
    /**
     * The query that was used to obtain the result
     * @var string
     */
    public string $query;
}
