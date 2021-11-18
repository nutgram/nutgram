<?php

namespace SergiX44\Nutgram\Telegram\Types\Chat;

use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * Represents a join request sent to a chat.
 * @see https://core.telegram.org/bots/api#chatjoinrequest
 */
class ChatJoinRequest
{
    /**
     * Chat to which the request was sent
     */
    public Chat $chat;

    /**
     * User that sent the join request
     */
    public User $from;

    /**
     * Date the request was sent in Unix time
     */
    public int $date;

    /**
     * Optional. Bio of the user.
     */
    public ?string $bio = null;

    /**
     * Optional. Chat invite link that was used by the user to send the join request
     */
    public ?ChatInviteLink $invite_link = null;
}
