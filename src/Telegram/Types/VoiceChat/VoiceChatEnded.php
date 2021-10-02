<?php

namespace SergiX44\Nutgram\Telegram\Types\VoiceChat;

/**
 * This object represents a service message about a voice chat ended in the chat.
 * @see https://core.telegram.org/bots/api#voicechatended
 */
class VoiceChatEnded
{
    /**
     * Voice chat duration; in seconds
     */
    public int $duration;
}
