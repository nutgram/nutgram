<?php

namespace SergiX44\Nutgram\Telegram\Types\Chat;

use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * Represents a join request sent to a chat.
 * @see https://core.telegram.org/bots/api#chatjoinrequest
 */
class ChatJoinRequest extends BaseType
{
    /** Chat to which the request was sent */
    public Chat $chat;

    /** User that sent the join request */
    public User $from;

    /**
     * Identifier of a private chat with the user who sent the join request.
     * This number may have more than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it.
     * But it has at most 52 significant bits, so a 64-bit integer or double-precision float type are safe for storing this identifier.
     * The bot can use this identifier for 24 hours to send messages until the join request is processed, assuming no other administrator contacted the user.
     */
    public int $user_chat_id;

    /** Date the request was sent in Unix time */
    public int $date;

    /**
     * Optional.
     * Bio of the user.
     */
    public ?string $bio = null;

    /**
     * Optional.
     * Chat invite link that was used by the user to send the join request
     */
    public ?ChatInviteLink $invite_link = null;
}
