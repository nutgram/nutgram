<?php


namespace SergiX44\Nutgram\Telegram\Endpoints;

use SergiX44\Nutgram\Telegram\Client;
use SergiX44\Nutgram\Telegram\Types\Media\File;
use SergiX44\Nutgram\Telegram\Types\Message\Message;
use SergiX44\Nutgram\Telegram\Types\Sticker\StickerSet;

/**
 * Trait Stickers
 * @package SergiX44\Nutgram\Telegram\Endpoints
 * @mixin Client
 */
trait Stickers
{
    /**
     * Use this method to send static .WEBP or
     * {@see https://telegram.org/blog/animated-stickers animated} .TGS stickers.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * @see https://core.telegram.org/bots/api#sendsticker
     * @param  mixed  $sticker Sticker to send. Pass a file_id as String to send a file that exists on the Telegram
     *     servers (recommended), pass an HTTP URL as a String for Telegram to get a .WEBP file from the Internet, or
     *     upload a new one using multipart/form-data.
     *     {@see https://core.telegram.org/bots/api#sending-files More info on Sending Files »}
     * @param  array  $opt
     * @return Message|null
     */
    public function sendSticker(mixed $sticker, array $opt = []): ?Message
    {
        return $this->sendAttachment(__FUNCTION__, 'sticker', $sticker, $opt);
    }

    /**
     * Use this method to get a sticker set.
     * On success, a {@see https://core.telegram.org/bots/api#stickerset StickerSet} object is returned.
     * @see https://core.telegram.org/bots/api#getstickerset
     * @param  string  $name Name of the sticker set
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
     * Use this method to create a new sticker set owned by a user.
     * The bot will be able to edit the sticker set thus created.
     * You must use exactly one of the fields png_sticker or tgs_sticker.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#createnewstickerset
     * @param  string  $name User identifier of created sticker set owner
     * @param  string  $title Short name of sticker set, to be used in t.me/addstickers/ URLs (e.g., animals). Can
     *     contain only english letters, digits and underscores. Must begin with a letter, can't contain consecutive
     *     underscores and must end in “_by_<bot username>”. <bot_username> is case insensitive. 1-64 characters.
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
     * Use this method to add a new sticker to a set created by the bot.
     * You must use exactly one of the fields png_sticker or tgs_sticker.
     * Animated stickers can be added to animated sticker sets and only to them.
     * Animated sticker sets can have up to 50 stickers.
     * Static sticker sets can have up to 120 stickers. Returns True on success.
     * @see https://core.telegram.org/bots/api#addstickertoset
     * @param  string  $name Sticker set name
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
     * Use this method to move a sticker in a set created by the bot to a specific position. Returns True on success.
     * @see https://core.telegram.org/bots/api#setstickerpositioninset
     * @param  string  $sticker File identifier of the sticker
     * @param  int  $position New sticker position in the set, zero-based
     * @return bool|null
     */
    public function setStickerPositionInSet(string $sticker, int $position): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('sticker', 'position'));
    }

    /**
     * Use this method to delete a sticker from a set created by the bot. Returns True on success.
     * @see https://core.telegram.org/bots/api#deletestickerfromset
     * @param  string  $sticker File identifier of the sticker
     * @return bool|null
     */
    public function deleteStickerFromSet(string $sticker): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('sticker'));
    }

    /**
     * Use this method to set the thumbnail of a sticker set.
     * Animated thumbnails can be set for animated sticker sets only.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#setstickersetthumb
     * @param  string  $name Sticker set name
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
