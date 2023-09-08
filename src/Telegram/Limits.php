<?php

namespace SergiX44\Nutgram\Telegram;

class Limits
{
    /**
     * Download file limit in Byte. (20 MB)
     * For the moment, bots can download files of up to 20MB in size.
     */
    public const DOWNLOAD = 20971520;

    /**
     * Upload file limit in Byte. (50 MB)
     */
    public const UPLOAD = 52428800;

    /**
     * Caption max characters length
     */
    public const CAPTION_LENGTH = 1024;

    /**
     * Text max characters length
     */
    public const TEXT_LENGTH = 4096;

    /**
     * Minimum period in seconds for which the location will be updated (1 minute)
     */
    public const MIN_LIVE_PERIOD = 60;

    /**
     * Maximum period in seconds for which the location will be updated (24 hours)
     */
    public const MAX_LIVE_PERIOD = 86400;

    /**
     * Maximum poll question length
     */
    public const POLL_QUESTION_LENGTH = 300;

    /**
     * Callback data max length in bytes
     */
    public const CALLBACK_DATA_LENGTH = 64;
}
