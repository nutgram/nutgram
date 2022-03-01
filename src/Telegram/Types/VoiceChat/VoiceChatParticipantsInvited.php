<?php

namespace SergiX44\Nutgram\Telegram\Types\VoiceChat;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents a service message about new members invited to a voice chat.
 * @see https://core.telegram.org/bots/api#voicechatparticipantsinvited
 */
class VoiceChatParticipantsInvited extends BaseType
{
    /**
     * Voice chat duration; in seconds
     * @var \SergiX44\Nutgram\Telegram\Types\User\User[] $users
     */
    public array $users;
}
