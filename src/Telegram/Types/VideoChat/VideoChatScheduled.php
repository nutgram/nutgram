<?php

namespace SergiX44\Nutgram\Telegram\Types\VideoChat;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents a service message about a video chat scheduled in the chat.
 * @see https://core.telegram.org/bots/api#videochatscheduled
 */
class VideoChatScheduled extends BaseType
{
    /** Point in time (Unix timestamp) when the video chat is supposed to be started by a chat administrator */
    public int $start_date;
}
