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
