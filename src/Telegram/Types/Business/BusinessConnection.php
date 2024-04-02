<?php

namespace SergiX44\Nutgram\Telegram\Types\Business;

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * Describes the connection of the bot with a business account.
 * @see https://core.telegram.org/bots/api#businessconnection
 */
class BusinessConnection extends BaseType
{
    /**
     * Unique identifier of the business connection
     */
    public string $id;

    /**
     * Business account user that created the business connection
     */
    public User $user;

    /**
     * Identifier of a private chat with the user who created the business connection.
     * This number may have more than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it.
     * But it has at most 52 significant bits, so a 64-bit integer or double-precision float type are safe for storing this identifier.
     */
    public int $user_chat_id;

    /**
     * Date the connection was established in Unix time
     */
    public int $date;

    /**
     * True, if the bot can act on behalf of the business account in chats that were active in the last 24 hours
     */
    public bool $can_reply;

    /**
     * True, if the connection is active
     */
    public bool $is_enabled;
}
