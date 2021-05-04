<?php


namespace SergiX44\Nutgram\Telegram\Endpoints;

use SergiX44\Nutgram\Telegram\Client;
use SergiX44\Nutgram\Telegram\Types\Message;
use SergiX44\Nutgram\Telegram\Types\StickerSet;

/**
 * Trait Stickers
 * @package SergiX44\Nutgram\Telegram\Endpoints
 * @mixin Client
 */
trait Stickers
{
    /**
     * @param $sticker
     * @param  array  $opt
     * @return Message|null
     */
    public function sendSticker($sticker, array $opt = []): ?Message
    {
        return $this->sendAttachment(__FUNCTION__, 'sticker', $sticker, $opt);
    }

    /**
     * @param  string  $name
     * @return StickerSet|null
     */
    public function getStickerSet(string $name): ?StickerSet
    {
        return $this->requestJson(__FUNCTION__, compact('name'), StickerSet::class);
    }

    /**
     * Use this method to upload a .PNG file with a sticker for later use in createNewStickerSet
     * and addStickerToSet methods (can be used multiple times).
     * Returns the uploaded {@see https://core.telegram.org/bots/api#file File} on success.
     * @see https://core.telegram.org/bots/api#uploadstickerfile
     * @param  mixed  $png_sticker PNG image with the sticker, must be up to 512 kilobytes in size, dimensions must not exceed 512px, and either width or height must be exactly 512px. {@see https://core.telegram.org/bots/api#sending-files More info on Sending Files »}
     * @param  array|null  $opt
     * @return File|null
     */
    public function uploadStickerFile(mixed $png_sticker, ?array $opt = []): ?File
    {
        $user_id = $this->userId();
        $required = compact('user_id', 'png_sticker');

        if (is_resource($png_sticker)) {
            return $this->requestMultipart(__FUNCTION__, array_merge($required, $opt), File::class);
        }

        return $this->requestJson(__FUNCTION__, array_merge($required, $opt), File::class);
    }

    /**
     * @param  string  $name
     * @param  string  $title
     * @param  array|null  $opt
     * @return bool|null
     */
    public function createNewStickerSet(string $name, string $title, ?array $opt = []): ?bool
    {
        $user_id = $this->userId();
        $required = compact('user_id', 'name', 'title');
        return $this->requestMultipart(__FUNCTION__, array_merge($required, $opt));
    }

    /**
     * @param  string  $name
     * @param  array|null  $opt
     * @return bool|null
     */
    public function addStickerToSet(string $name, ?array $opt = []): ?bool
    {
        $user_id = $this->userId();
        $required = compact('user_id', 'name');
        return $this->requestMultipart(__FUNCTION__, array_merge($required, $opt));
    }

    /**
     * @param  string  $sticker
     * @param  int  $position
     * @return bool|null
     */
    public function setStickerPositionInSet(string $sticker, int $position): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('sticker', 'position'));
    }

    /**
     * @param  string  $sticker
     * @return bool|null
     */
    public function deleteStickerFromSet(string $sticker): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('sticker'));
    }

    /**
     * @param  string  $name
     * @param  array|null  $opt
     * @return bool|null
     */
    public function setStickerSetThumb(string $name, ?array $opt = []): ?bool
    {
        $user_id = $this->userId();
        $required = compact('user_id', 'name');
        return $this->requestMultipart(__FUNCTION__, array_merge($required, $opt));
    }
}
