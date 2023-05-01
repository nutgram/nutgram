<?php

namespace SergiX44\Nutgram\Telegram\Types\VideoChat;

use SergiX44\Hydrator\Annotation\ArrayType;
use SergiX44\Nutgram\Telegram\Types\BaseType;
use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * This object represents a service message about new members invited to a video chat.
 * @see https://core.telegram.org/bots/api#videochatparticipantsinvited
 */
class VideoChatParticipantsInvited extends BaseType
{
    /**
     * New members that were invited to the video chat
     * @var User[] $users
     */
    #[ArrayType(User::class)]
    public array $users;
}
