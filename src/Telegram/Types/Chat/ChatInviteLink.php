<?php

namespace SergiX44\Nutgram\Telegram\Types\Chat;

use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * Represents an invite link for a chat.
 * @see https://core.telegram.org/bots/api#chatinvitelink
 */
class ChatInviteLink
{
    /**
     * The invite link. If the link was created by another chat administrator,
     * then the second part of the link will be replaced with “…”.
     */
    public string $invite_link;

    /**
     * Creator of the link
     */
    public User $creator;

    /**
     * True, if the link is primary
     */
    public bool $is_primary;

    /**
     * True, if the link is revoked
     */
    public bool $is_revoked;

    /**
     * Optional. Point in time (Unix timestamp) when the link will expire or has been expired
     */
    public ?int $expire_date = null;

    /**
     * Optional. Maximum number of users that can be members of the chat simultaneously
     * after joining the chat via this invite link; 1-99999
     */
    public ?int $member_limit = null;
}
