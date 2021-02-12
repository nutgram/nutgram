<?php

namespace SergiX44\Nutgram\Telegram\Types;

/**
 * This object represents a file uploaded to Telegram Passport.
 * Currently all Telegram Passport files are in JPEG format when decrypted and don't exceed 10MB.
 * @see https://core.telegram.org/bots/api#passportfile
 */
class PassportFile
{
    /**
     * Unique identifier for this file
     * @var string
     */
    public string $file_id;

    /**
     * Unique identifier for this file, which is supposed to be the same over time and for different bots.
     * Can't be used to download or reuse the file.
     * @var string
     */
    public string $file_unique_id;

    /**
     * File size
     * @var int
     */
    public int $file_size;

    /**
     * Unix time when the file was uploaded
     * @var int
     */
    public int $file_date;
}
