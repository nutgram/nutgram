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
     * @return Message
     */
    public function sendSticker($sticker, array $opt = []): Message
    {
        return $this->sendAttachment('sticker', $sticker, $opt);
    }

    /**
     * @param  string  $name
     * @return StickerSet
     */
    public function getStickerSet(string $name): StickerSet
    {
        return $this->requestJson(__FUNCTION__, compact('name'), StickerSet::class);
    }

    /**
     * @param  string  $name
     * @param  string  $title
     * @param  array|null  $opt
     * @return bool
     */
    public function createNewStickerSet(string $name, string $title, ?array $opt = []): bool
    {
        $user_id = $this->userId();
        $required = compact('user_id', 'name', 'title');
        return $this->requestMultipart(__FUNCTION__, array_merge($required, $opt));
    }

}