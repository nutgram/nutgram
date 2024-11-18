<?php

namespace SergiX44\Nutgram\Telegram\Endpoints;

use SergiX44\Nutgram\Telegram\Client;
use SergiX44\Nutgram\Telegram\Properties\StickerFormat;
use SergiX44\Nutgram\Telegram\Properties\StickerType;
use SergiX44\Nutgram\Telegram\Types\Input\InputSticker;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;
use SergiX44\Nutgram\Telegram\Types\Internal\UploadableArray;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ForceReply;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardRemove;
use SergiX44\Nutgram\Telegram\Types\Media\File;
use SergiX44\Nutgram\Telegram\Types\Message\Message;
use SergiX44\Nutgram\Telegram\Types\Message\ReplyParameters;
use SergiX44\Nutgram\Telegram\Types\Sticker\Gifts;
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
     * Use this method to send static .WEBP, {@see https://telegram.org/blog/animated-stickers animated} .TGS, or {@see https://telegram.org/blog/video-stickers-better-reactions video} .WEBM stickers.
     * On success, the sent {@see https://core.telegram.org/bots/api#message Message} is returned.
     * @see https://core.telegram.org/bots/api#sendsticker
     * @param InputFile|string $sticker Sticker to send. Pass a file_id as String to send a file that exists on the Telegram servers (recommended), pass an HTTP URL as a String for Telegram to get a .WEBP sticker from the Internet, or upload a new .WEBP or .TGS sticker using multipart/form-data. {@see https://core.telegram.org/bots/api#sending-files More information on Sending Files »}. Video stickers can only be sent by a file_id. Animated stickers can't be sent via an HTTP URL.
     * @param int|string|null $chat_id Unique identifier for the target chat or username of the target channel (in the format &#64;channelusername)
     * @param int|null $message_thread_id Unique identifier for the target message thread (topic) of the forum; for forum supergroups only
     * @param string|null $emoji Emoji associated with the sticker; only for just uploaded stickers
     * @param bool|null $disable_notification Sends the message {@see https://telegram.org/blog/channels-2-0#silent-messages silently}. Users will receive a notification with no sound.
     * @param bool|null $protect_content Protects the contents of the sent message from forwarding and saving
     * @param int|null $reply_to_message_id If the message is a reply, ID of the original message
     * @param bool|null $allow_sending_without_reply Pass True if the message should be sent even if the specified replied-to message is not found
     * @param ReplyParameters|null $reply_parameters Description of the message to reply to
     * @param InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup Additional interface options. A JSON-serialized object for an {@see https://core.telegram.org/bots/features#inline-keyboards inline keyboard}, {@see https://core.telegram.org/bots/features#keyboards custom reply keyboard}, instructions to remove reply keyboard or to force a reply from the user.
     * @param string|null $business_connection_id Unique identifier of the business connection on behalf of which the message will be sent
     * @param string|null $message_effect_id Unique identifier of the message effect to be added to the message; for private chats only
     * @param bool|null $allow_paid_broadcast Pass True to allow up to 1000 messages per second, ignoring {@see https://core.telegram.org/bots/faq#how-can-i-message-all-of-my-bot-39s-subscribers-at-once broadcasting limits} for a fee of 0.1 Telegram Stars per message. The relevant Stars will be withdrawn from the bot's balance
     * @param array $clientOpt Client options
     * @return Message|null
     */
    public function sendSticker(
        InputFile|string $sticker,
        int|string|null $chat_id = null,
        ?int $message_thread_id = null,
        ?string $emoji = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
        ?int $reply_to_message_id = null,
        ?bool $allow_sending_without_reply = null,
        ?ReplyParameters $reply_parameters = null,
        InlineKeyboardMarkup|ReplyKeyboardMarkup|ReplyKeyboardRemove|ForceReply|null $reply_markup = null,
        ?string $business_connection_id = null,
        ?string $message_effect_id = null,
        ?bool $allow_paid_broadcast = null,
        array $clientOpt = [],
    ): ?Message {
        $chat_id ??= $this->chatId();
        $message_thread_id ??= $this->messageThreadId();
        $business_connection_id ??= $this->businessConnectionId();
        $opt = compact(
            'chat_id',
            'message_thread_id',
            'emoji',
            'disable_notification',
            'protect_content',
            'reply_to_message_id',
            'allow_sending_without_reply',
            'reply_parameters',
            'reply_markup',
            'business_connection_id',
            'message_effect_id',
            'allow_paid_broadcast',
        );

        return $this->sendAttachment(__FUNCTION__, 'sticker', $sticker, $opt, $clientOpt);
    }

    /**
     * Use this method to get a sticker set.
     * On success, a {@see https://core.telegram.org/bots/api#stickerset StickerSet} object is returned.
     * @see https://core.telegram.org/bots/api#getstickerset
     * @param string $name Name of the sticker set
     * @return StickerSet|null
     */
    public function getStickerSet(string $name): ?StickerSet
    {
        return $this->requestJson(__FUNCTION__, compact('name'), StickerSet::class);
    }

    /**
     * Use this method to upload a file with a sticker for later use in the {@see https://core.telegram.org/bots/api#createnewstickerset createNewStickerSet} and {@see https://core.telegram.org/bots/api#addstickertoset addStickerToSet} methods (the file can be used multiple times).
     * Returns the uploaded {@see https://core.telegram.org/bots/api#file File} on success.
     * @see https://core.telegram.org/bots/api#uploadstickerfile
     * @param InputFile|string $sticker {@see https://core.telegram.org/stickers }A file with the sticker in .WEBP, .PNG, .TGS, or .WEBM format. See {@see https://core.telegram.org/stickers https://core.telegram.org/stickers} for technical requirements. {@see https://core.telegram.org/bots/api#sending-files More information on Sending Files »}
     * @param StickerFormat|string $sticker_format Format of the sticker, must be one of “static”, “animated”, “video”
     * @param int|null $user_id User identifier of sticker file owner
     * @param array $clientOpt Client options
     * @return File|null
     */
    public function uploadStickerFile(
        InputFile|string $sticker,
        StickerFormat|string $sticker_format,
        ?int $user_id = null,
        array $clientOpt = [],
    ): ?File {
        $user_id ??= $this->userId();
        $parameters = compact('user_id', 'sticker', 'sticker_format');

        if ($sticker instanceof InputFile) {
            return $this->requestMultipart(__FUNCTION__, $parameters, File::class, $clientOpt);
        }

        return $this->requestJson(__FUNCTION__, $parameters, File::class);
    }

    /**
     * Use this method to create a new sticker set owned by a user.
     * The bot will be able to edit the sticker set thus created.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#createnewstickerset
     * @param string $name Short name of sticker set, to be used in t.me/addstickers/ URLs (e.g., animals). Can contain only English letters, digits and underscores. Must begin with a letter, can't contain consecutive underscores and must end in "_by_<bot_username>". <bot_username> is case insensitive. 1-64 characters.
     * @param string $title Sticker set title, 1-64 characters
     * @param InputSticker[] $stickers A JSON-serialized list of 1-50 initial stickers to be added to the sticker set
     * @param StickerFormat|string|null $sticker_format DEPRECATED. Use format in Sticker class instead
     * @param int|null $user_id User identifier of created sticker set owner
     * @param StickerType|string|null $sticker_type Type of stickers in the set, pass “regular”, “mask”, or “custom_emoji”. By default, a regular sticker set is created.
     * @param bool|null $needs_repainting Pass True if stickers in the sticker set must be repainted to the color of text when used in messages, the accent color if used as emoji status, white on chat photos, or another appropriate color based on context; for custom emoji sticker sets only
     * @param array $clientOpt Client options
     * @return bool|null
     */
    public function createNewStickerSet(
        string $name,
        string $title,
        array $stickers,
        StickerFormat|string|null $sticker_format = null,
        ?int $user_id = null,
        StickerType|string|null $sticker_type = null,
        ?bool $needs_repainting = null,
        array $clientOpt = [],
    ): ?bool {
        $user_id ??= $this->userId();
        $parameters = compact(
            'user_id',
            'name',
            'title',
            'sticker_format',
            'sticker_type',
            'needs_repainting',
        );
        $parameters['stickers'] = new UploadableArray($stickers);

        return $this->requestMultipart(__FUNCTION__, $parameters, options: $clientOpt);
    }

    /**
     * Use this method to add a new sticker to a set created by the bot.
     * The format of the added sticker must match the format of the other stickers in the set.
     * Emoji sticker sets can have up to 200 stickers.
     * Animated and video sticker sets can have up to 50 stickers.
     * Static sticker sets can have up to 120 stickers.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#addstickertoset
     * @param string $name Sticker set name
     * @param InputSticker $sticker A JSON-serialized object with information about the added sticker. If exactly the same sticker had already been added to the set, then the set isn't changed.
     * @param int|null $user_id User identifier of sticker set owner
     * @param array $clientOpt Client options
     * @return bool|null
     */
    public function addStickerToSet(
        string $name,
        InputSticker $sticker,
        ?int $user_id = null,
        array $clientOpt = [],
    ): ?bool {
        $user_id ??= $this->userId();
        $parameters = compact(
            'user_id',
            'name',
            'sticker',
        );

        return $this->requestMultipart(__FUNCTION__, $parameters, options: $clientOpt);
    }

    /**
     * Use this method to move a sticker in a set created by the bot to a specific position.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#setstickerpositioninset
     * @param string $sticker File identifier of the sticker
     * @param int $position New sticker position in the set, zero-based
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
     * @param string $name Sticker set name
     * @param string|null $custom_emoji_id Custom emoji identifier of a sticker from the sticker set; pass an empty string to drop the thumbnail and use the first sticker as the thumbnail.
     * @return bool|null
     */
    public function setCustomEmojiStickerSetThumbnail(string $name, ?string $custom_emoji_id = null): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('name', 'custom_emoji_id'));
    }

    /**
     * Use this method to delete a sticker from a set created by the bot.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#deletestickerfromset
     * @param string $sticker File identifier of the sticker
     * @return bool|null
     */
    public function deleteStickerFromSet(string $sticker): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('sticker'));
    }

    /**
     * Use this method to replace an existing sticker in a sticker set with a new one.
     * The method is equivalent to calling {@see https://core.telegram.org/bots/api#deletestickerfromset deleteStickerFromSet},
     * then {@see https://core.telegram.org/bots/api#addstickertoset addStickerToSet},
     * then {@see https://core.telegram.org/bots/api#setstickerpositioninset setStickerPositionInSet}.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#replacestickerinset
     * @param string $name Sticker set name
     * @param string $old_sticker File identifier of the replaced sticker
     * @param InputSticker $sticker A JSON-serialized object with information about the added sticker. If exactly the same sticker had already been added to the set, then the set remains unchanged.
     * @param int|null $user_id User identifier of the sticker set owner
     * @param array $clientOpt Client options
     * @return bool|null
     */
    public function replaceStickerInSet(string $name, string $old_sticker, InputSticker $sticker, ?int $user_id = null, array $clientOpt = []): ?bool
    {
        $user_id ??= $this->userId();
        $parameters = compact(
            'user_id',
            'name',
            'old_sticker',
            'sticker',
        );

        return $this->requestMultipart(__FUNCTION__, $parameters, options: $clientOpt);
    }

    /**
     * Use this method to change the list of emoji assigned to a regular or custom emoji sticker.
     * The sticker must belong to a sticker set created by the bot.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#setstickeremojilist
     * @param string $sticker File identifier of the sticker
     * @param string[] $emoji_list A JSON-serialized list of 1-20 emoji associated with the sticker
     * @return bool|null
     */
    public function setStickerEmojiList(string $sticker, array $emoji_list): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('sticker', 'emoji_list'));
    }

    /**
     * Use this method to change search keywords assigned to a regular or custom emoji sticker.
     * The sticker must belong to a sticker set created by the bot.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#setstickerkeywords
     * @param string $sticker File identifier of the sticker
     * @param string[]|null $keywords A JSON-serialized list of 0-20 search keywords for the sticker with total length of up to 64 characters
     * @return bool|null
     */
    public function setStickerKeywords(string $sticker, ?array $keywords = null): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('sticker', 'keywords'));
    }

    /**
     * Use this method to change the {@see https://core.telegram.org/bots/api#maskposition mask position} of a mask sticker.
     * The sticker must belong to a sticker set that was created by the bot.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#setstickermaskposition
     * @param string $sticker File identifier of the sticker
     * @param MaskPosition|null $mask_position A JSON-serialized object with the position where the mask should be placed on faces. Omit the parameter to remove the mask position.
     * @return bool|null
     */
    public function setStickerMaskPosition(string $sticker, ?MaskPosition $mask_position = null): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('sticker', 'mask_position'));
    }

    /**
     * Use this method to set the thumbnail of a regular or mask sticker set.
     * The format of the thumbnail file must match the format of the stickers in the set.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#setstickersetthumbnail
     * @param string $name Sticker set name
     * @param StickerFormat|string $format Format of the thumbnail, must be one of “static” for a .WEBP or .PNG image, “animated” for a .TGS animation, or “video” for a WEBM video
     * @param int|null $user_id User identifier of the sticker set owner
     * @param InputFile|string|null $thumbnail {@see https://core.telegram.org/stickers#animated-sticker-requirements }{@see https://core.telegram.org/stickers#video-sticker-requirements }A .WEBP or .PNG image with the thumbnail, must be up to 128 kilobytes in size and have a width and height of exactly 100px, {@see https://core.telegram.org/stickers#animated-sticker-requirements https://core.telegram.org/stickers#animated-sticker-requirements}(see https://core.telegram.org/stickers#animated-sticker-requirements for animated sticker technical requirements), or a WEBM video with the thumbnail up to 32 kilobytes in size; see {@see https://core.telegram.org/stickers#video-sticker-requirements https://core.telegram.org/stickers#video-sticker-requirements} for video sticker technical requirements. Pass a file_id as a String to send a file that already exists on the Telegram servers, pass an HTTP URL as a String for Telegram to get a file from the Internet, or upload a new one using multipart/form-data. {@see https://core.telegram.org/bots/api#sending-files More information on Sending Files »}. Animated and video sticker set thumbnails can't be uploaded via HTTP URL. If omitted, then the thumbnail is dropped and the first sticker is used as the thumbnail.
     * @param array $clientOpt Client options
     * @return bool|null
     */
    public function setStickerSetThumbnail(
        string $name,
        StickerFormat|string $format = StickerFormat::STATIC,
        ?int $user_id = null,
        InputFile|string|null $thumbnail = null,
        array $clientOpt = [],
    ): ?bool {
        $user_id ??= $this->userId();
        $parameters = compact('name', 'format', 'user_id', 'thumbnail');

        return $this->requestMultipart(__FUNCTION__, $parameters, options: $clientOpt);
    }

    /**
     * Use this method to get information about custom emoji stickers by their identifiers.
     * Returns an Array of {@see https://core.telegram.org/bots/api#sticker Sticker} objects.
     * @see https://core.telegram.org/bots/api#getcustomemojistickers
     * @param string[] $custom_emoji_ids List of custom emoji identifiers. At most 200 custom emoji identifiers can be specified.
     * @return Sticker[]|null
     */
    public function getCustomEmojiStickers(array $custom_emoji_ids): ?array
    {
        return $this->requestJson(__FUNCTION__, compact('custom_emoji_ids'), Sticker::class);
    }

    /**
     * Use this method to set the title of a created sticker set.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#setstickersettitle
     * @param string $name Sticker set name
     * @param string $title Sticker set title, 1-64 characters
     * @return bool|null
     */
    public function setStickerSetTitle(string $name, string $title): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('name', 'title'));
    }

    /**
     * Use this method to delete a sticker set that was created by the bot.
     * Returns True on success.
     * @see https://core.telegram.org/bots/api#deletestickerset
     * @param string $name Sticker set name
     * @return bool|null
     */
    public function deleteStickerSet(string $name): ?bool
    {
        return $this->requestJson(__FUNCTION__, compact('name'));
    }

    /**
     * Returns the list of gifts that can be sent by the bot to users. Requires no parameters. Returns a Gifts object.
     * @return Gifts|null
     * @see https://core.telegram.org/bots/api#getavailablegifts
     */
    public function getAvailableGifts(): ?Gifts
    {
        return $this->requestJson(__FUNCTION__, mapTo: Gifts::class);
    }

    /**
     * Sends a gift to the given user.
     * The gift can't be converted to Telegram Stars by the user.
     * Returns True on success.
     * @param string $gift_id Identifier of the gift
     * @param int|null $user_id Unique identifier of the target user that will receive the gift
     * @param string|null $text Text that will be shown along with the gift; 0-255 characters
     * @param string|null $text_parse_mode Mode for parsing entities in the text. See {@see formatting options https://core.telegram.org/bots/api#formatting-options} for more details. Entities other than “bold”, “italic”, “underline”, “strikethrough”, “spoiler”, and “custom_emoji” are ignored.
     * @param array|null $text_entities A JSON-serialized list of special entities that appear in the gift text. It can be specified instead of text_parse_mode. Entities other than “bold”, “italic”, “underline”, “strikethrough”, “spoiler”, and “custom_emoji” are ignored.
     * @return bool|null
     * @see https://core.telegram.org/bots/api#sendgift
     */
    public function sendGift(
        string $gift_id,
        ?int $user_id = null,
        ?string $text = null,
        ?string $text_parse_mode = null,
        ?array $text_entities = null,
    ): ?bool {
        $user_id ??= $this->userId();
        $parameters = compact('gift_id', 'user_id', 'text', 'text_parse_mode', 'text_entities');
        return $this->requestJson(__FUNCTION__, $parameters);
    }
}
