<?php

namespace SergiX44\Nutgram\Telegram\Types\VoiceChat;

use SergiX44\Nutgram\Telegram\Types\User\User;

/**
 * This object represents a service message about new members invited to a voice chat.
 * @see https://core.telegram.org/bots/api#voicechatparticipantsinvited
 */
class VoiceChatParticipantsInvited
{
    /**
     * Voice chat duration; in seconds
     * @var User[] $users
     */
    public $users;
}
