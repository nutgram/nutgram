<?php

namespace SergiX44\Nutgram\Telegram\Types\Media;

use SergiX44\Nutgram\Telegram\Types\BaseType;

/**
 * This object represents a file ready to be downloaded.
 * The file can be downloaded via the link https://api.telegram.org/file/bot<token>/<file_path>.
 * It is guaranteed that the link will be valid for at least 1 hour.
 * When the link expires, a new one can be requested by calling {@see https://core.telegram.org/bots/api#getfile getFile}.
 * @see https://core.telegram.org/bots/api#file
 */
class File extends BaseType
{
    /** Identifier for this file, which can be used to download or reuse the file */
    public string $file_id;

    /**
     * Unique identifier for this file, which is supposed to be the same over time and for different bots.
     * Can't be used to download or reuse the file.
     */
    public string $file_unique_id;

    /**
     * Optional.
     * File size in bytes.
     * It can be bigger than 2^31 and some programming languages may have difficulty/silent defects in interpreting it.
     * But it has at most 52 significant bits, so a signed 64-bit integer or double-precision float type are safe for storing this value.
     */
    public ?int $file_size = null;

    /**
     * Optional.
     * File path.
     * Use https://api.telegram.org/file/bot<token>/<file_path> to get the file.
     */
    public ?string $file_path = null;

    /**
     * @param  string  $path
     * @param  array  $clientOpt
     * @return bool|null
     */
    public function save(string $path, array $clientOpt = []): ?bool
    {
        if (is_dir($path)) {
            $path = rtrim($path, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
            $path .= basename($this->file_path ?? $this->file_id);
        }
        return $this->getBot()?->downloadFile($this, $path, $clientOpt);
    }

    /**
     * @return string|null
     */
    public function url(): string|null
    {
        return $this->getBot()?->downloadUrl($this);
    }
}
