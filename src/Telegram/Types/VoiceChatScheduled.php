<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * This object represents a service message about a voice chat scheduled in the chat.
 * @see https://core.telegram.org/bots/api#voicechatscheduled
 */
class VoiceChatScheduled
{
    /**
     * Point in time (Unix timestamp) when the voice chat is supposed to be started by a chat administrator
     * @var int $start_date
     */
    public $start_date;
}
