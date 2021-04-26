<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * This object represents an incoming inline query.
 * When the user sends an empty query, your bot could return some default or trending results.
 * @see https://core.telegram.org/bots/api#inlinequery
 */
class InlineQuery
{
    /**
     * Unique identifier for this query
     * @var string $id
     */
    public $id;
    
    /**
     * Sender
     * @var User $from
     */
    public $from;
    
    /**
     * Text of the query (up to 256 characters)
     * @var string $query
     */
    public $query;
    
    /**
     * Offset of the results to be returned, can be controlled by the bot
     * @var string $offset
     */
    public $offset;

    /**
     * Optional. Type of the chat, from which the inline query was sent.
     * Can be either “sender” for a private chat with the inline query sender,
     * “private”, “group”, “supergroup”, or “channel”.
     * The chat type should be always known for requests sent from official clients and most third-party clients,
     * unless the request was sent from a secret chat
     * @var string $chat_type
     */
    public $chat_type;

    /**
     * Optional. Sender location, only for bots that request user location
     * @var Location $location
     */
    public $location;
}
