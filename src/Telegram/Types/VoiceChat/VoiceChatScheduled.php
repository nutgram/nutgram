<?php

namespace SergiX44\Nutgram\Telegram\Types\VoiceChat;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents a service message about a voice chat scheduled in the chat.
 * @see https://core.telegram.org/bots/api#voicechatscheduled
 */
class VoiceChatScheduled extends BaseType
{
    /**
     * Point in time (Unix timestamp) when the voice chat is supposed to be started by a chat administrator
     */
    public int $start_date;
}
