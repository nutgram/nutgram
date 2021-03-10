<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * Represents an invite link for a chat.
 * @see https://core.telegram.org/bots/api#chatinvitelink
 */
class ChatInviteLink
{
    /**
     * The invite link. If the link was created by another chat administrator,
     * then the second part of the link will be replaced with “…”.
     * @var string $invite_link
     */
    public $invite_link;

    /**
     * Creator of the link
     * @var User $creator
     */
    public $creator;

    /**
     * True, if the link is primary
     * @var bool $is_primary
     */
    public $is_primary;

    /**
     * True, if the link is revoked
     * @var bool $is_revoked
     */
    public $is_revoked;

    /**
     * Optional. Point in time (Unix timestamp) when the link will expire or has been expired
     * @var int $expire_date
     */
    public $expire_date;

    /**
     * Optional. Maximum number of users that can be members of the chat simultaneously
     * after joining the chat via this invite link; 1-99999
     * @var int $member_limit
     */
    public $member_limit;
}
