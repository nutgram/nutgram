<?php

namespace SergiX44\Nutgram\Telegram\Types\VideoChat;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents a service message about a video chat ended in the chat.
 * @see https://core.telegram.org/bots/api#videochatended
 */
class VideoChatEnded extends BaseType
{
    /** Video chat duration in seconds */
    public int $duration;
}
