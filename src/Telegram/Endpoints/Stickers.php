<?php


namespace SergiX44\Nutgram\Telegram\Endpoints;

use SergiX44\Nutgram\Telegram\Client;
use SergiX44\Nutgram\Telegram\Types\Input\InputSticker;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ForceReply;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardRemove;
use SergiX44\Nutgram\Telegram\Types\Media\File;
use SergiX44\Nutgram\Telegram\Types\Message\Message;
use SergiX44\Nutgram\Telegram\Types\Sticker\MaskPosition;
use SergiX44\Nutgram\Telegram\Types\Sticker\Sticker;
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
     * @param  array{
     *     message_thread_id?:int,
     *     emoji?:string,
     *     disable_notification?:bool,
     *     protect_content?:bool,
     *     reply_to_message_id?:int,
     *     allow_sending_without_reply?:bool,
     *     reply_markup?:InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply
     * }  $opt
     * @param  array  $clientOpt
     * @return Message|null
     */
    public function sendSticker(mixed $sticker, array $opt = [], array $clientOpt = []): ?Message
    {
        return $this->sendAttachment(__FUNCTION__, 'sticker', $sticker, $opt, $clientOpt);
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
     * @param  mixed  $sticker A file with the sticker in .WEBP, .PNG, .TGS, or .WEBM format.
     *      See {@see https://core.telegram.org/stickers https://core.telegram.org/stickers} for technical requirements.
     *      {@see https://core.telegram.org/bots/api#sending-files More info on Sending Files »}
     * @param  array{
     *     sticker_format?:string,
     * }  $opt
     * @param  array  $clientOpt
     * @return File|null
     */
    public function uploadStickerFile(mixed $sticker, array $opt = [], array $clientOpt = []): ?File
    {
        $user_id = $this->userId();
        $required = compact('user_id', 'sticker');

        if (is_resource($sticker)) {
            return $this->requestMultipart(__FUNCTION__, array_merge($required, $opt), File::class, $clientOpt);
        }

        return $this->requestJson(__FUNCTION__, array_merge($required, $opt), File::class);
    }

    /**
     * Use this method to create a new sticker set owned by a user.
     * The bot will be able to edit the sticker set thus created.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#createnewstickerset
     * @param  string  $name User identifier of created sticker set owner
     * @param  string  $title Short name of sticker set, to be used in t.me/addstickers/ URLs (e.g., animals). Can
     *     contain only english letters, digits and underscores. Must begin with a letter, can't contain consecutive
     *     underscores and must end in “_by_<bot username>”. <bot_username> is case insensitive. 1-64 characters.
     * @param  array{
     *     stickers?:InputSticker[],
     *     sticker_format?:string,
     *     sticker_type?:string,
     *     needs_repainting?:bool,
     * }  $opt
     * @param  array  $clientOpt
     * @return bool|null
     */
    public function createNewStickerSet(string $name, string $title, array $opt = [], array $clientOpt = []): ?bool
    {
        $user_id = $this->userId();
        $required = compact('user_id', 'name', 'title');
        return $this->requestMultipart(__FUNCTION__, array_merge($required, $opt), options: $clientOpt);
    }

    /**
     * Use this method to add a new sticker to a set created by the bot.
     * You must use exactly one of the fields png_sticker or tgs_sticker.
     * Animated stickers can be added to animated sticker sets and only to them.
     * Animated sticker sets can have up to 50 stickers.
     * Static sticker sets can have up to 120 stickers. Returns True on success.
     * @see https://core.telegram.org/bots/api#addstickertoset
     * @param  string  $name Sticker set name
     * @param  array{
     *     stickers?:InputSticker,
     * }  $opt
     * @param  array  $clientOpt
     * @return bool|null
     */
    public function addStickerToSet(string $name, array $opt = [], array $clientOpt = []): ?bool
    {
        $user_id = $this->userId();
        $required = compact('user_id', 'name');
        return $this->requestMultipart(__FUNCTION__, array_merge($required, $opt), options: $clientOpt);
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
     * Use this method to set the thumbnail of a custom emoji sticker set.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#setcustomemojistickersetthumbnail
     * @param  string  $name Sticker set name
     * @param  array{
     *     custom_emoji_id?:string,
     * }  $opt
     * @return bool
     */
    public function setCustomEmojiStickerSetThumbnail(string $name, array $opt = []): bool
    {
        return $this->requestJson(__FUNCTION__, array_merge(compact('name'), $opt));
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
     * Use this method to change the list of emoji assigned to a regular or custom emoji sticker.
     * The sticker must belong to a sticker set created by the bot.
     * Returns True on success.
     * @param  string  $sticker File identifier of the sticker
     * @param  array  $emoji_list A list of 1-20 emoji associated with the sticker
     * @return bool
     */
    public function setStickerEmojiList(string $sticker, array $emoji_list): bool
    {
        return $this->requestJson(__FUNCTION__, compact('sticker', 'emoji_list'));
    }

    /**
     * Use this method to change search keywords assigned to a regular or custom emoji sticker.
     * The sticker must belong to a sticker set created by the bot.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#setstickerkeywords
     * @param  string  $sticker File identifier of the sticker
     * @param  array{
     *     keywords?:string[],
     * }  $opt
     * @return bool
     */
    public function setStickerKeywords(string $sticker, array $opt = []): bool
    {
        return $this->requestJson(__FUNCTION__, array_merge(compact('sticker'), $opt));
    }

    /**
     * Use this method to change the mask position of a mask sticker.
     * The sticker must belong to a sticker set that was created by the bot.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#setstickermaskposition
     * @param  string  $sticker
     * @param  array{
     *     mask_position?:MaskPosition[],
     * }  $opt
     * @return bool
     */
    public function setStickerMaskPosition(string $sticker, array $opt = []): bool
    {
        return $this->requestJson(__FUNCTION__, array_merge(compact('sticker'), $opt));
    }

    /**
     * Use this method to set the thumbnail of a sticker set.
     * Animated thumbnails can be set for animated sticker sets only.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#setstickersetthumb
     * @param  string  $name Sticker set name
     * @param  array{
     *     thumb?:InputFile|string
     * }  $opt
     * @param  array  $clientOpt
     * @return bool|null
     */
    public function setStickerSetThumbnail(string $name, array $opt = [], array $clientOpt = []): ?bool
    {
        $user_id = $this->userId();
        $required = compact('user_id', 'name');
        return $this->requestMultipart(__FUNCTION__, array_merge($required, $opt), options: $clientOpt);
    }

    /**
     * Use this method to get information about custom emoji stickers by their identifiers.
     * Returns an Array of Sticker objects.
     * @see https://core.telegram.org/bots/api#getcustomemojistickers
     * @param  array{string}  $emoji_ids
     * @return array|null
     */
    public function getCustomEmojiStickers(array $emoji_ids): ?array
    {
        return $this->requestJson(__FUNCTION__, $emoji_ids, Sticker::class);
    }

    /**
     * Use this method to set the title of a created sticker set.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#setstickersettitle
     * @param  string  $name Sticker set name
     * @param  string  $title Sticker set title, 1-64 characters
     * @return bool
     */
    public function setStickerSetTitle(string $name, string $title): bool
    {
        return $this->requestJson(__FUNCTION__, compact('name', 'title'));
    }

    /**
     * Use this method to delete a sticker set that was created by the bot.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#deletestickerset
     * @param  string  $name Sticker set name
     * @return bool
     */
    public function deleteStickerSet(string $name): bool
    {
        return $this->requestJson(__FUNCTION__, compact('name'));
    }
}
