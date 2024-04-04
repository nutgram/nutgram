<?php

namespace SergiX44\Nutgram\Telegram\Types\Business;

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\Chat\Chat;

/**
 * This object is received when messages are deleted from a connected business account.
 * @see https://core.telegram.org/bots/api#businessmessagesdeleted
 */
class BusinessMessagesDeleted extends BaseType
{
    /**
     * Unique identifier of the business connection
     */
    public string $business_connection_id;

    /**
     * Information about a chat in the business account. The bot may not have access to the chat or the corresponding user.
     */
    public Chat $chat;

    /**
     * A JSON-serialized list of identifiers of deleted messages in the chat of the business account
     * @var int[]
     */
    public array $message_ids;
}
