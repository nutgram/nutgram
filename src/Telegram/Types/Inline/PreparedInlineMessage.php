<?php

namespace SergiX44\Nutgram\Telegram\Types\Inline;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * Describes an inline message to be sent by a user of a Mini App.
 * @see https://core.telegram.org/bots/api#preparedinlinemessage
 */
class PreparedInlineMessage extends BaseType
{
    /**
     * Unique identifier of the prepared message
     */
    public string $id;

    /**
     * Expiration date of the prepared message, in Unix time.
     * Expired prepared messages can no longer be used
     */
    public int $expiration_date;
}
